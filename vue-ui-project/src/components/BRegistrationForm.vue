<template>
  <div class="registration-form border-main">
    <div class="registration-form__title">Registration</div>
    <hr class="divider" />
    <div class="registration-form__nickname-fields">
      <b-text-input
        type="text"
        placeholder="First name"
        :validation-prop="$v.form.firstName"
        v-model.trim="form.firstName"
      />
      <b-text-input
        type="text"
        placeholder="Last name"
        :validation-prop="$v.form.lastName"
        v-model.trim="form.lastName"
      />
    </div>
    <b-text-input
      type="email"
      placeholder="Email address"
      :validation-prop="$v.form.email"
      v-model.trim="form.email"
    />
    <button @click="signUp" class="button button_color_green">Sign up</button>
  </div>
</template>

<script>
import BTextInput from "@/components/BTextInput";
import { email, minLength, required } from "vuelidate/lib/validators";
import router from "@/router";
import AuthApi from "@/api/auth.js";

export default {
  name: "BRegistrationForm",
  components: { BTextInput },
  data() {
    return {
      form: {
        firstName: "",
        lastName: "",
        email: "",
      },
    };
  },
  validations: {
    form: {
      firstName: {
        required,
        minLength: minLength(2),
      },
      lastName: {
        required,
        minLength: minLength(2),
      },
      email: {
        email,
        required,
      },
    },
  },
  methods: {
    async signUp() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.error("Please enter correct data");
        return;
      }

      try {
        await AuthApi.registration(this.form);

        router.push({ name: "login-view" });

        this.$toasted.success("Success! Password send to your email.");
      } catch (error) {
        this.$toasted.error(error);
      }
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/registration-form.sass"
</style>
