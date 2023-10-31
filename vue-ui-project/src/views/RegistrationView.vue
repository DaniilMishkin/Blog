<template>
  <div class="main-wrapper main-wrapper_vh_100">
    <div class="registration-view">
      <b-registration-form />
    </div>
  </div>
</template>

<script>
import BRegistrationForm from "@/components/BRegistrationForm";

export default {
  name: "RegistrationView",
  components: { BRegistrationForm },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/pages/registration.sass"
</style>
