import Vue from 'vue'
import VueRouter from 'vue-router'
// import store from './../state/store'
// import routes from './routes'
Vue.use(VueRouter)

import store from './../state/store';

import Dashboard from "./../pages/Dashboard";
import Login from "./../pages/Login";
import Overview from "./../pages/Overview/index";




import CategoryIndex from "./../pages/Category/index";
import Category from "./../pages/Category/Category";



import Admins from "../pages/Usermanagement/Admins.vue"

const router = new VueRouter({
    mode: "history",
    // routes,
    routes: [{
        path: "/administrator-login",
        name: "login",
        component: Login
    },

    {
        path: "/administrator-dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { requiresAuth: true },
        children: [
            {
                path: "",
                name: "Overview",
                component: Overview
            },
            {
                path: "projects",
                name: "CateoryIndex",
                component: CategoryIndex,

            },
            {
                path: "project",
                name: "newCategory",
                component: Category,

            },
            {
                path: "project/:id",
                name: "viewCategory",
                component: Category
            },

        ]
    }
    ]
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next("/administrator-login");
    } else {
        next();
    }
});
export default router
