<template>
  <div class="reset-pass-form border-main">
    <div class="reset-pass-form__title">Reset your password</div>
    <hr class="divider" />
    <b-text-input
      type="email"
      placeholder="Email address"
      :validation-prop="$v.form.email"
      v-model.trim="form.email"
    />
    <b-text-input
      type="password"
      placeholder="New password"
      :validation-prop="$v.form.password"
      v-model.trim="form.password"
    />
    <b-text-input
      type="password"
      placeholder="Repeat password"
      :validation-prop="$v.form.passwordConfirmation"
      v-model.trim="form.passwordConfirmation"
    />
    <div class="reset-pass-form__buttons">
      <button @click="goToLogin" class="button button_color_gray">
        Cancel
      </button>
      <button @click="resetPassword" class="button button_color_blue">
        Reset
      </button>
    </div>
  </div>
</template>

<script>
import BTextInput from "@/components/BTextInput";
import { email, minLength, required, sameAs } from "vuelidate/lib/validators";
import router from "@/router";
import Auth from "@/api/auth";

export default {
  name: "BResetPasswordForm",
  components: { BTextInput },
  data() {
    return {
      form: {
        email: "",
        password: "",
        passwordConfirmation: "",
        token: this.$route.params.token,
      },
    };
  },
  validations: {
    form: {
      email: {
        required,
        email,
      },
      password: {
        required,
        minLength: minLength(8),
      },
      passwordConfirmation: {
        required,
        sameAs: sameAs("password"),
      },
    },
  },
  methods: {
    goToLogin() {
      router.push({ name: "login-view" });
    },
    async resetPassword() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.$toasted.error("Please enter correct data");
        return;
      }

      try {
        await Auth.setCsrfCookie();
        await Auth.resetPassword(this.form);

        this.$toasted.success("Your password changed");

        router.push({ name: "login-view" });
      } catch (error) {
        this.$toasted.error(error);
      }
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/reset-pass-form.sass"
</style>
