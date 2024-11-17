import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios; 

const token = localStorage.getItem('authToken');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}
