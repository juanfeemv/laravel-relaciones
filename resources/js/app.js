//Función que crea la aplicación Vue
import { createApp } from 'vue'
//Importa Pinia para poder usar estado global
import { createPinia } from 'pinia'
//Importa el sistema de rutas (vue-router)
import router from './router'
//Importa el componente raíz
import App from './App.vue'

const app = createApp(App)
//Activa Pinia dentro de la aplicación
app.use(createPinia())
//Activa el sistema de rutas
app.use(router)
//Vue se renderiza en el HTML
app.mount('#app')