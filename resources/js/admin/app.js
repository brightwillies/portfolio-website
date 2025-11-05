 require('./bootstrap');
import Vue from "vue";
window.Vue = require("vue");
// import VueRouter from "vue-router";
// Vue.use(VueRouter);


import Vuelidate from 'vuelidate'
import VueSweetalert2 from 'vue-sweetalert2';
import store from './state/store'
// import i18n from './i18n'
import mixin from './mixin'


import router from './router';
Vue.use(Vuelidate)
Vue.use(VueSweetalert2);


Vue.prototype.$churchusername = localStorage.getItem('grocery_admin_firstname');


import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

import { VueEditor } from "vue2-editor";
Vue.component('vue-editor', VueEditor)



import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
Vue.component('v-select', vSelect);


/**image viewer */

import Viewer from "v-viewer";
import 'viewerjs/dist/viewer.css'
Vue.use(Viewer);
/**end of image */


import Toasted from "vue-toasted";
Vue.use(Toasted, {
    duration: 9000,
    position: "top-right",
    action: {
        text: "Okay",
        onClick: (e, toastObject) => {
            toastObject.goAway(0);
        }
    }
});

import { ToggleButton } from 'vue-js-toggle-button'

Vue.component('ToggleButton', ToggleButton);


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


import App from "./pages/App";
const app = new Vue({
    el: "#app",
    router,
    store,
    mixin,
    render: h => h(App),
});
