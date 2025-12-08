import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({ // indique à Vite quels fichiers sont entrés pour que Vite les compile, sert au Hot Module Replacement (HMR)
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(), // permet à Vite de comprendre et compiler les fichiers .vue., sert au Hot Module Replacement (HMR)
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js', // compile les templates à la volée
        },
    },
});
