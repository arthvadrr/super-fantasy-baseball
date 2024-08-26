import { createWebHistory, createRouter } from 'vue-router';
import LoadingScreen from './views/LoginLoading.vue';
import LoginScreen from './views/Login.vue';
import HomeScreen from './views/Dashboard.vue';

const routes = [
    { path: '/', component: LoadingScreen },
    { path: '/login', component: LoginScreen },
    { path: '/home', component: HomeScreen },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;