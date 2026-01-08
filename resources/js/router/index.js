//createRouter crea el sistema de rutas
//createWebHistory usa URLs normales (/login, /users, etc.)
import { createRouter, createWebHistory } from 'vue-router'
//Importamos los componentes que actuarán como páginas
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'
//definición de rutas
const routes = [
    { path: '/login', component: Login },
    { path: '/', component: Dashboard },
]
//Aquí se construye el router con el tipo de navegación y la lista
const router = createRouter({
    history: createWebHistory(),
    routes,
})
//Permite que el router se use en otros archivos
export default router