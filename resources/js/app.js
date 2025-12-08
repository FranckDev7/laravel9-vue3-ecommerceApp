import './bootstrap';
import { createApp } from 'vue'
import AddToCart from "./components/AddToCart.vue";
import NavbarCart from "./components/NavbarCart.vue";
import ShoppingCart from "./components/ShoppingCart.vue";
import StripeCheckout from "./components/StripeCheckout.vue";

import Alpine from 'alpinejs';
import {Toaster} from "@meforma/vue-toaster";

window.Alpine = Alpine;

Alpine.start();

// Crée une instance d'application Vue 3.
const app = createApp({});

// Installe des plugins à mon instance d'application Vue 3
// .provide() : méthode Vue qui injecte une valeur dans l’application ou un composant racine.
// 'toast' : clé utilisée pour récupérer la valeur avec inject() dans les composants enfants
// app.config.globalProperties.$toast : valeur qu'on veut partager
// app.config : retourne un objet de configuration pour l’application Vue.
// app.config.globalProperties : proprieté de l'objet 'app.config' et contient
//                               toutes les propriétés globales accessibles dans tous les composants.
app.use(Toaster, {
    position: "top",
}).provide('toast', app.config.globalProperties.$toast);

// déclare les composants globaux dans mon application.
app.component('AddToCart', AddToCart)
app.component('NavbarCart', NavbarCart)
app.component('ShoppingCart', ShoppingCart)
app.component('StripeCheckout', StripeCheckout)

// Monte mon application Vue dans le DOM
app.mount('#app');
