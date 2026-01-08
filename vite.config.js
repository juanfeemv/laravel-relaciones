//Función básica de Vite para definir su configuración
import { defineConfig } from 'vite'
//Plugin que conecta Vite con Laravel.
import laravel from 'laravel-vite-plugin'
//Plugin que permite a Vite entender archivos .vue
import vue from '@vitejs/plugin-vue'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
})