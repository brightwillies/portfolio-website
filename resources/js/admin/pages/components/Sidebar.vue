<template>
    <div class="sidebar-wrapper">
        <div id="sidebarEffect"></div>
        <div>
            <div class="logo-wrapper logo-wrapper-center">
                <a href="/administrator-dashboard" data-bs-original-title="" title="">
                    <img class="img-fluid for-white" src="/fassets/images/header-logo.svg" alt="logo">
                </a>
                <div class="back-btn">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div class="toggle-sidebar">
                    <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
                </div>
            </div>
            <div class="logo-icon-wrapper">
                <a href="/administrator-dashboard">
                    Home
                    <!-- <img class="img-fluid main-logo main-white" src="/fassets/images/header-logo.svg" alt="logo">
                    <img class="img-fluid main-logo main-dark" src="/fassets/images/header-logo.svg"
                        alt="logo"> -->
                </a>
            </div>

    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow">
            <i data-feather="arrow-left"></i>
        </div>

        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"></li>

                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title link-nav" href="/administrator-dashboard">
                        <i class="ri-home-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                

                <li class="sidebar-list" >
                    <a class="linear-icon-link sidebar-link sidebar-title" href="javascript:void(0)">
                        <i class="ri-list-check-2"></i>
                        <span>Projects</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>

                            <a href="/administrator-dashboard/projects">Project List</a>
                        </li>

                        <li>
                            <a href="/administrator-dashboard/project">Add New Project</a>
                        </li>
                    </ul>
                </li>

<!--
                <li class="sidebar-list"  >
                    <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                        <i class="ri-user-3-line"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sidebar-submenu">
                       <li v-if="checkpermission('perm_admin')">

                            <a href="/administrator-dashboard/admins">Administrator</a>
                        </li>
                       <li v-if="checkpermission('perm_roles')">

                            <a href="/administrator-dashboard/roles">Roles</a>
                        </li>


                    </ul>
                </li> -->

            </ul>
        </div>

        <div class="right-arrow" id="right-arrow">
            <i data-feather="arrow-right"></i>
        </div>
    </nav>


</div>
</div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>

</style>
