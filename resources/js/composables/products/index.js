import axios from "axios";
import {ref} from "vue";

export default function useProduct () {
    const products = ref([]);
    const cartCount = ref(0)
    const getProducts = async () => {
        const response = await axios.get('/api/products');
        products.value = Object.values(response.data.cartContent);
        cartCount.value = response.data.cartCount

        console.log("reponse du backend à l'URL /api/products : ", response)
    }


    const add = async (productId) => {
        const response = await axios.post('/api/products', {
            productId: productId
        })
        console.log("reponse de la requête vers l'URL /api/products", response)

        return response.data.count;
    }

    const getCount = async () => {
        const response = await axios.get('/api/products/count')
        return response.data.count;
    }

    const increaseQuantity = async (id) => {
        await axios.get('/api/products/increase/' + id)
    }

    const decreaseQuantity = async (id) => {
        await axios.get('/api/products/decrease/' + id)
    }

    // Aappel l’URL /api/products/{id} en méthode HTTP DELETE.
    const destroyProduct = async (id) => {
        await axios.delete('/api/products/' + id)
    }

    // (Vide le panier) Aappel l’URL /api/cart en méthode HTTP DELETE.
    const clearCartApi = async () => {
        await axios.delete('/api/cart') // ta route DELETE pour vider le panier
    }




    return {
        add,
        getCount,
        products,
        getProducts,
        increaseQuantity,
        decreaseQuantity,
        destroyProduct,
        cartCount,
        clearCartApi
    }
}
