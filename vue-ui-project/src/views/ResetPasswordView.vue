<template>
  <div class="main-wrapper main-wrapper_vh_100">
    <div class="reset-password-view">
      <b-reset-password-form />
    </div>
  </div>
</template>

<script>
import BResetPasswordForm from "@/components/BResetPasswordForm";

export default {
  name: "ResetPasswordView",
  components: { BResetPasswordForm },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/pages/reset-pass.sass"
</style>
