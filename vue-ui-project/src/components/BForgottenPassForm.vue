<template>
  <div class="forgotten-pass-form border-main">
    <div class="forgotten-pass-form__title">Find your account</div>
    <hr class="divider" />
    <div class="forgotten-pass-form__help-text">
      Please enter your email address to search for your account
    </div>
    <b-text-input
      type="email"
      placeholder="Email address"
      :validation-prop="$v.email"
      v-model.trim="email"
    />
    <div class="forgotten-pass-form__buttons">
      <button @click="goToLoginView" class="button button_color_gray">
        Cancel
      </button>
      <button @click="search" class="button button_color_blue">Search</button>
    </div>
  </div>
</template>

<script>
import BTextInput from "@/components/BTextInput";
import { email, required } from "vuelidate/lib/validators";
import router from "@/router";
import Auth from "@/api/auth";

export default {
  name: "BForgottenPassForm",
  components: { BTextInput },
  data() {
    return {
      email: "",
    };
  },
  validations: {
    email: {
      required,
      email,
    },
  },
  methods: {
    async search() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.error("Please enter correct data");
        return;
      }

      try {
        await Auth.forgotPassword({
          email: this.email,
        });
        this.$toasted.success("Message send to yor email");
      } catch (error) {
        this.$toasted.error(error);
      }
    },
    goToLoginView() {
      router.push({ name: "login-view" });
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/forgotten-pass-form.sass"
</style>
