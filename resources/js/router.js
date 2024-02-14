import { createWebHistory, createRouter } from "vue-router";
import home from "./pages/Home.vue"
import login from "./pages/Login.vue"
import register from "./pages/Register.vue"
import contactos from "./pages/Contactos.vue"
const routes = [
    {
        path: '/',
        name: 'Home',
        component: home,
        meta: {
            requiresAuth:true
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: login
    },
    {
        path: '/register',
        name: 'Register',
        component: register,
        meta: {
            requiresAuth:false
        }
    },
    {
        path: '/contactos',
        name: 'Contactos',
        component: contactos,
        meta: {
            requiresAuth:true
        }
    }
];
const router = createRouter({
    history: createWebHistory(),
    routes
});
router.beforeEach((to, from) => {
    if(to.meta.requiresAuth && !localStorage.getItem('token')) {
        return {name: 'Login'}
    }
    if(to.meta.requiresAuth == false && localStorage.getItem('token')) {
        return {name: 'Login'}
    }
})
export default router;