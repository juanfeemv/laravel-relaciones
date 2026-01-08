import axios from 'axios'
//instancia personalizada de Axios
const api = axios.create({
    baseURL: '/api/v1',
    headers: {
        Accept: 'application/json',
    },
})
// Lee token de localStorage si existe
const token = localStorage.getItem('token')
if (token) {
    api.defaults.headers.common.Authorization = `Bearer ${token}`
}
//Guardar el token cuando el usuario hace login y eliminarlo
export function setAuthToken(token) {
    if (token) {
        //Guarda el token y lo añade a Axios
        localStorage.setItem('token', token)
        api.defaults.headers.common.Authorization = `Bearer ${token}`
    } else {
        //Borra el token y deja de enviarlo a la API
        localStorage.removeItem('token')
        delete api.defaults.headers.common.Authorization
    }
}
//Permite usar api.get(), api.post(), etc., en cualquier parte del
proyecto
export default api