
<template>
    <div>
        <section class="log-in-section section-b-space">
            <a href="/administrator-login" class="logo-login"></a>
            <div class="container w-100">
                <div class="row">

                    <div class="col-xl-5 col-lg-6 me-auto">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3>Welcome To EaglexpressD</h3>
                                <h4>Log In Your Account</h4>
                            </div>

                            <div class="input-box">
                                <form @submit.prevent="adminLogin" class="row g-4">
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="email" v-model="email" class="form-control" id="email"
                                                placeholder="Email Address">
                                            <label for="email">Email Address</label>
                                        </div>


                                        <div v-if="submitted && $v.email.$error" class="invalid-feedback">



                                            <span v-if="!$v.email.required">Email is required.</span>



                                            <span v-if="!$v.email.email">Please enter valid email.</span>



                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="text" v-model="password" class="form-control" id="password"
                                                placeholder="Password">
                                            <label for="password">Password</label>
                                        </div>


                                        <div v-if="submitted && !$v.password.required" class="invalid-feedback">Password
                                            is required.



                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="forgot-box">
                                            <div class="form-check ps-0 m-0 remember-box">
                                                <input class="checkbox_animated check-box" type="checkbox"
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Remember
                                                    me</label>
                                            </div>
                                            <a href="#" class="forgot-password">Forgot Password?</a>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100 justify-content-center" type="submit">Log
                                            In</button>
                                    </div>
                                </form>
                            </div>

                            <div class="other-log-in">

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";
import store from './../state/store';

export default {
    data() {
        return {
            email: "",
            password: "",
            submitted: false
        };
    },
    computed: {
        notification() {
            return this.$store ? this.$store.state.notification : null;
        }
    },
    created() {


    },
    validations: {
        email: { required, email },
        password: { required }
    },
    methods: {

        adminLogin() {


            this.submitted = true;
            // stop here if form is invalid
            this.$v.$touch();

            if (this.$v.$invalid) {
                return;
            } else {

                var vm = this;
                let formData = new FormData();
                formData.append("email", this.email);
                formData.append("password", this.password);
                axios
                    .post("/api/admin/v1/auth/login", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then(
                        (response) => {




                            if (response) {
                                const res = response.data;

                                if (res.code == 200) {
                                    var userData = res.data;

                                    localStorage.setItem("grocery_admin", userData.user.mask);
                                    localStorage.setItem("grocery_admin_firstname", userData.user.first_name);
                                    localStorage.setItem("grocery_admin_pass", userData.token);
                                    localStorage.setItem("permissions", userData.permissions);
                                    // localStorage.setItem("grocery_admin_region", userData.user.region_id);
                                    // axios.defaults.headers.common["Authorization"] =
                                    //     "Bearer " + userData.token;
                                    store.commit("loginUser");
                                    this.successToastRedirect(res.message, "/administrator-dashboard");

                                } else {
                                    vm.$toasted.show(res.message);
                                }
                            }
                        },
                        function (error) {
                            vm.isActive = false;

                            if (error.response) {
                                console.log(error.response.data.errors);
                                error.response.data.errors.forEach((element) => {
                                    vm.$toasted.show(element);
                                });
                                // alert(error.response.status);
                            }
                        }
                    );
            }
        }


    }
};
</script>

<style scoped>
.bg-forgot-password {
    background-image: url(/assets/images/login/bg.png);
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
}

.container-fluid {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    width: 100%;
    padding-right: calc(1.5rem * .5);
    padding-left: calc(1.5rem * .5);
    margin-right: auto;
    margin-left: auto;
}

.authentication-card {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    max-width: 50rem;
    height: 100vh;
}

.rounded-5 {
    border-radius: 2px !important;
}

.shadow {
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
}

.overflow-hidden {
    overflow: hidden !important;
}

#subButton {
    margin-top: 20px;
    width: 100%;
}
</style>
