<template>
  <div class="main-wrapper main-wrapper_vh_100">
    <div class="forgotten-pass-view">
      <b-forgotten-pass-form />
    </div>
  </div>
</template>

<script>
import BForgottenPassForm from "@/components/BForgottenPassForm";
export default {
  name: "ForgottenPassView",
  components: { BForgottenPassForm },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/pages/forgotten-pass.sass"
</style>
