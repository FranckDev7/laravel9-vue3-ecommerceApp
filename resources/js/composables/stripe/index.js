import {ref} from 'vue'
import {saveOrder} from "../../helpers/index";

export default function useStripe() {
    let elements = ref(null);
    let stripe = ref(null);

    // Initialisation du Payment Element
    const initialize = async () => {
        stripe.value = Stripe(import.meta.env.VITE_STRIPE_TEST_PUBLIC_KEY);

        const clientSecret = await axios.post('/paymentIntent')
            .then(r => r.data.clientSecret)
            .catch(err => console.log(err))

        elements.value = stripe.value.elements({ clientSecret });

        const paymentElementOptions = {
            layout: "accordion",
        };

        const paymentElement = elements.value.create("payment", paymentElementOptions);
        paymentElement.mount("#payment-element");
    }

    // Gestion du formulaire de paiement
    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        // Confirme le paiement côté frontend
        const { paymentIntent, error } = await stripe.value.confirmPayment({
            elements: elements.value,
            redirect: 'if_required', // empêche la redirection automatique
        });

        if (error) {
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }
            setLoading(false);
            return;
        }

        // Si le paiement est réussi
        // paymentIntent : objet contenant les info de paiement
        if (paymentIntent && paymentIntent.status === 'succeeded') {
            try {
                await saveOrder(); // appelle ton endpoint Laravel pour créer la commande
                showMessage("Paiement réussi ! Votre commande a été enregistrée.");
                // Redirige manuellement vers la page de succès
                window.location.href = "/checkout/success";
            } catch (err) {
                showMessage("Paiement réussi mais la commande n'a pas pu être enregistrée.");
                console.error(err);
            }
        }

        setLoading(false);
    };



    const showMessage = (messageText) => {
        const messageContainer = document.querySelector("#payment-message");

        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageContainer.textContent = "";
        }, 4000);
    }

    // Show a spinner on payment submission
    const setLoading = (isLoading) => {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }


    return {
      initialize,
      handleSubmit,
    }
}


