import { createWebHistory, createRouter } from 'vue-router';
import LoadingView from './views/LoginLoading.vue';
import LoginView from './views/Login.vue';
import DashboardView from './views/Dashboard.vue';
import RosterView from './views/Roster.vue';
import LeagueView from './views/League.vue';
import CalendarView from './views/Calendar.vue';

const routes = [
    { path: '/', component: LoadingView },
    { path: '/login', component: LoginView },
    { path: '/dashboard', component: DashboardView },
    { path: '/roster', component: RosterView },
    { path: '/league', component: LeagueView },
    { path: '/calendar', component: CalendarView },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;