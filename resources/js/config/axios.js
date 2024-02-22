import axios from 'axios'

const axiosInstance = axios.create({
    baseURL: `${window.env.apiUrl}/api/`,
    headers:{
        "Content-Type": 'application/json',
    }
})

export default axiosInstance;
