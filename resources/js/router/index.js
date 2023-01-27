import { createRouter, createWebHistory } from "vue-router";
//ADMIN
import homeAdminIndex from "../components/admin/home/index.vue";
import homeAboutIndex from '../components/admin/about/index.vue'
//PAGE
import homePageIndex from "../components/pages/home/index.vue";
//NOT PAGES
import notFound from "../components/notFound.vue";
// login
import login from "../components/auth/login.vue";
// 

const routes = [
    //Admin
    {
        path: "/admin/home",
        name: "homeAdminIndex",
        component: homeAdminIndex,
        meta:{
            requiresAuth: true
        }
    },
    //Page
    {
        path: "/",
        name: "homePageIndex",
        component: homePageIndex,
        meta:{
            requiresAuth: true
        }
    },
    //Not Pages
    {
        path: "/:pathMatch(.*)*",
        name: "notFound",
        component: notFound,
        meta:{
            requiresAuth: false
        }
    },
    //login
    {
        path: "/login",
        name: "login",
        component: login,
        meta:{
            requiresAuth: false
        }
    },
    // about
    {
        path: "/admin/about",
        name: "homeAboutIndex",
        component: homeAboutIndex,
        meta:{
            requiresAuth: true
        }
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        return {
            name: 'login'
        }
    }
    if(to.meta.requiresAuth == false && localStorage.getItem('token')){
        return {
            name: 'adminHome'
        }
    }
});

export default router;
