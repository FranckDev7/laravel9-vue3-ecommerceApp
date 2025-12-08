<template>
    <div class="space-x-8 sm:ml-10 sm:flex mr-10">
        <a href="/shoppingCart" class="relative">
            <span class="absolute -top-1 left-4 rounded-full bg-indigo-700 w-5 h-5 text-xs text-white flex items-center justify-center">
                {{ cartCount }}
            </span>
            <span class="material-symbols-outlined">
                shopping_bag
            </span>
        </a>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import useProduct from "../composables/products";

const { getCount } = useProduct()
const cartCount = ref(0);

// tiny-emitter avec import ESM
import emitter from 'tiny-emitter/instance';

emitter.on('cartCountUpdated', (count) => cartCount.value = count)

onMounted(async () => {
    cartCount.value = await getCount()
})
</script>
