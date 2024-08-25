import { createWebHistory, createRouter } from 'vue-router';
import LoadingScreen from './components/LoginLoading.vue';
import LoginScreen from './components/Login.vue';
import HomeScreen from './components/Home.vue';

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