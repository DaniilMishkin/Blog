<template>
  <div class="login-form border-main">
    <b-text-input
      type="email"
      placeholder="Email address"
      :validation-prop="$v.form.email"
      v-model.trim="form.email"
    />
    <b-text-input
      type="password"
      placeholder="Your password"
      :validation-prop="$v.form.password"
      v-model.trim="form.password"
    />
    <button @click="logIn" class="button button_color_blue">Log in</button>
    <div @click="goToForgottenPassView" class="login-form__link">
      Forgotten password?
    </div>
    <hr class="divider" />
    <button
      @click="goToRegistrationView"
      class="button button_color_green"
      role="link"
    >
      Create new account
    </button>
  </div>
</template>

<script>
import BTextInput from "@/components/BTextInput";
import { email, required } from "vuelidate/lib/validators";
import router from "@/router";
import AuthApi from "@/api/auth";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "BLoginForm",
  components: { BTextInput },
  data() {
    return {
      form: {
        email: "",
        password: "",
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
      },
    },
  },
  methods: {
    ...mapActions(["setLoggedUser"]),
    async logIn() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.error("Please enter correct data");
        return;
      }

      try {
        await AuthApi.setCsrfCookie();
        await AuthApi.login(this.form);
        await this.setLoggedUser();

        router.push({
          name: "profile-view",
          params: { id: this.loggedUser.id },
        });

        this.$toasted.success(`Hi, ${this.loggedUser.firstName}`);
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    goToRegistrationView() {
      router.push({ name: "registration-view" });
    },
    goToForgottenPassView() {
      router.push({ name: "forgotten-pass-view" });
    },
  },
  computed: {
    ...mapGetters({
      loggedUser: "loggedUser",
    }),
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/login-form"
</style>
