<template>
  <div class="main-wrapper main-wrapper_vh_100">
    <div class="login-view">
      <div class="login-view__logo">
        <div class="login-view__logo-img">
          <img
            src="@/assets/images/pngfind.com-bmw-logo-png-1007888.png"
            alt=""
          />
        </div>
        <div class="login-view__logo-title">BimmerBlog</div>
      </div>
      <b-login-form />
    </div>
  </div>
</template>

<script>
import BLoginForm from "@/components/BLoginForm";

export default {
  name: "LoginView",
  components: { BLoginForm },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/pages/login.sass"
</style>
