import {createApp} from 'vue'

require('./bootstrap')
import App from './App.vue'
import axios from 'axios'
import router from './router'
import Loader from './components/loader'; 
import '@fortawesome/fontawesome-free/css/all.css'
// Set up axios globally:
window.axios = axios;

// Configure the default headers for axios:
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Define the base URL for all axios requests:
axios.defaults.baseURL = 'http://localhost:8000';

if (localStorage.getItem('token')) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
}

// Handle token expiration or invalid tokens:
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Remove the token from local storage:
            localStorage.removeItem('token');

            // Reset the axios Authorization header:
            axios.defaults.headers.common['Authorization'] = 'Bearer';

            // Redirect the user to the login page:
            router.push({ name: 'login' });
        }
        return Promise.reject(error);
    }
);


const app = createApp(App)
app.component('Loader', Loader); 
app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app')


