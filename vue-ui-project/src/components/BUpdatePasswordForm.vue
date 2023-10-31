<template>
  <div class="update-password-form">
    <div class="update-password-form__row">
      <div class="update-password-form__row-title">Old password</div>
      <b-text-input
        type="password"
        placeholder="Old Password"
        :validation-prop="$v.passwordConfig.password"
        v-model.trim="$v.passwordConfig.password.$model"
      />
    </div>
    <div class="update-password-form__row">
      <div class="update-password-form__row-title">New password</div>
      <b-text-input
        type="password"
        placeholder="New Password"
        :validation-prop="$v.passwordConfig.newPassword"
        v-model.trim="$v.passwordConfig.newPassword.$model"
      />
    </div>
    <div class="update-password-form__row">
      <div class="update-password-form__row-title">Repeat password</div>
      <b-text-input
        type="password"
        placeholder="Repeat new Password"
        :validation-prop="$v.passwordConfig.newPasswordConfirmation"
        v-model.trim="$v.passwordConfig.newPasswordConfirmation.$model"
      />
    </div>
    <div class="button button_color_blue" @click="updatePassword">
      Reset password
    </div>
  </div>
</template>

<script>
import BTextInput from "@/components/BTextInput";
import AuthApi from "@/api/auth";
import { minLength, sameAs } from "vuelidate/lib/validators";

export default {
  name: "BUpdatePasswordForm",
  components: { BTextInput },
  data() {
    return {
      passwordConfig: {
        password: "",
        newPassword: "",
        newPasswordConfirmation: "",
      },
    };
  },
  methods: {
    resetPasswordConfig() {
      this.passwordConfig = {
        password: "",
        newPassword: "",
        newPasswordConfirmation: "",
      };
    },
    async updatePassword() {
      try {
        await AuthApi.updatePassword(this.passwordConfig);

        this.resetPasswordConfig();

        this.$toasted.success("Password updated");
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
  },
  validations: {
    passwordConfig: {
      password: {
        minLength: minLength(8),
      },
      newPassword: {
        minLength: minLength(8),
      },
      newPasswordConfirmation: {
        minLength: minLength(8),
        sameAs: sameAs("newPassword"),
      },
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/update-password-form.sass"
</style>
