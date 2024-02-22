import axios from 'axios'

/**
 * Permite crear una instancia de axios comun para todas las peticiones, lo que evita redundancia de codigo y al tener una sola instancia, en caso de algun error es mas facil manejarlo
 * @type {axios.AxiosInstance}
 */
const axiosInstance = axios.create({
    baseURL: `${window.env.apiUrl}/api/`,
    headers:{
        "Content-Type": 'application/json',
    }
})

export default axiosInstance;
