<template>
    <div class="page-header">
        <div class="header-wrapper m-0">
            <div class="header-logo-wrapper p-0">
                <div class="logo-wrapper">
                    <a href="/administrator-dashboard">
                        <img class="img-fluid main-logo" src="/resources/admin/assets/images/logo/1.png" alt="logo">
                        <img class="img-fluid white-logo" src="/resources/admin/assets/images/logo/1-white.png"
                            alt="logo">
                    </a>
                </div>
                <div class="toggle-sidebar">
                    <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
                    <a href="/administrator-dashboard">
                        <img src="/resources/admin/assets/images/logo/1.png" class="img-fluid" alt="">
                    </a>
                </div>
            </div>


            <div class="nav-right col-6 pull-right right-header p-0">
                <ul class="nav-menus">
                    <li>
                        <span class="header-search">
                            <i class="ri-search-line"></i>
                        </span>
                    </li>

                    <li>
                        <div class="mode">
                            <i class="ri-moon-line"></i>
                        </div>
                    </li>
                    <li class="profile-nav onhover-dropdown pe-0 me-0">
                        <div class="media profile-media">
                            <img class="user-profile rounded-circle" src="/resources/admin/assets/images/users/4.jpg"
                                alt="">
                            <div class="user-name-hide media-body">
                                <span>{{ this.$churchusername }}</span>
                                <p class="mb-0 font-roboto">Admin<i class="middle ri-arrow-down-s-line"></i></p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">

                          
                            <li>
                                <a @click="logout" href="javascript:void(0)">
                                    <i data-feather="log-out"></i>
                                    <span>Log out</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    methods: {

        logout(e) {
            e.preventDefault();
            delete axios.defaults.headers.common["Authorization"];
            localStorage.removeItem("grocery_admin");
            localStorage.removeItem("grocery_admin_firstname");
            localStorage.removeItem("grocery_admin_pass");
            localStorage.removeItem("permissions");
            window.location.replace("/administrator-login");
        },
    }
}
</script>

<style lang="scss" scoped></style>
