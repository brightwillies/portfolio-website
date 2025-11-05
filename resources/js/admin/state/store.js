import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem('grocery_admin_pass'),

    },

    mutations: {

        loginUser(state) {
            state.isLoggedIn = true
           
        },
        logoutUser(state) {
            state.isLoggedIn = false
        },
        toastMessage(message) {
            var messageT = message
            const Toast = swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 4500,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener("mouseenter", swal.stopTimer);
                        toast.addEventListener("mouseleave", swal.resumeTimer);
                    },
                },
                function() {}
            );
            Toast.fire({
                icon: "success",
                title: messageT,
            }).then(function() {

                window.location.reload();
            });
        }

    },


    getters: {
        isLoggedIn: state => !!state.isLoggedIn
    }
})
export default store


