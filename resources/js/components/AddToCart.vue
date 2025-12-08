<template>
    <button
        class="w-full py-2 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-700 transition flex justify-center items-center gap-2"
        @click.prevent="addToCart"
    >
        <span class="material-symbols-outlined">
            add_shopping_cart
        </span>
        <span>ajouter au panier</span>
    </button>
</template>

<script setup>
    import axios from "axios";
    import useProduct from '../composables/products/index'
    import emitter from 'tiny-emitter/instance';
    import {inject} from "vue";

    const productId = defineProps(['productId'])
    const { add } = useProduct();
    const toast = inject('toast') // inject la valeur de la clé 'toast'


    // Laravel Sanctum utilise les cookies pour l’authentification de SPA (Vue, React, Svelt, etc).
    // initialiser le cookie CSRF veut dire :
    //    - Créer un cookie XSRF-TOKEN dans le navigateur.
    //    - Ce cookie contiendra un token CSRF que Laravel utilisera pour valider tes requêtes POST/PUT/DELETE.
    //    - enfin toutes tes requêtes via Axios ou Fetch vers le backend Laravel pourront inclure ce token pour être acceptées.
    const addToCart = async () => {
        await axios.get('/sanctum/csrf-cookie');
        await axios.get('/api/user')
            .then(async (res) => {
                // Ajouter le produit au panier
                const cartCount = await add(productId);
                emitter.emit('cartCountUpdated', cartCount);
                toast.success('produit ajouté avec succès')

                console.log("reponse de la requête vers l'URL /api/user :", res)
            })
            .catch(() => {
                toast.error('Veuillez vous connecter pour ajouter un produit !')
            })
    }
</script>

<style scoped>

</style>
