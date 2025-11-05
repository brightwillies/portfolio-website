<template>
  <div>
    <router-view :key="$route.fullPath"></router-view>
  </div>
</template>

<script>
import axios from "axios";
 import store from "./../state/store";
export default {
  mounted() {

    if (store.getters.isLoggedIn && this.$route.path == "/superadmin-login") {
      this.$router.push("/administrator-dashboard"); // redirect to home, for example
    }

  },
};
</script>
