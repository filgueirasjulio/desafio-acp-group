import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js'; 
import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';
import LoginForm from './components/LoginForm.vue';
import Dashboard from './components/Dashboard.vue';

// Definindo as rotas
const routes = [
    { path: '/login', component: LoginForm, name: 'login-form' },
    { path: '/dashboard', component: Dashboard, name: 'dashboard' },  
];

// Criando o router
const router = createRouter({
    history: createWebHistory(),
    routes, 
});

// Criando o app Vue
const app = createApp(App);

app.use(router);  
app.mount('#app'); 