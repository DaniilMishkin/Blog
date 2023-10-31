<template>
  <div class="edit-profile-form border-main">
    <div class="edit-profile-form__row">
      <div class="edit-profile-form__row-title">Email address</div>
      {{ profile.email }}
    </div>
    <div class="edit-profile-form__row">
      <div class="edit-profile-form__row-title">First name</div>
      <b-text-input
        type="text"
        placeholder="First name"
        :validation-prop="$v.profile.firstName"
        v-model.trim="profile.firstName"
      />
    </div>
    <div class="edit-profile-form__row">
      <div class="edit-profile-form__row-title">Last name</div>
      <b-text-input
        type="text"
        placeholder="Last name"
        :validation-prop="$v.profile.lastName"
        v-model.trim="profile.lastName"
      />
    </div>
    <hr class="divider" />
    <div class="edit-profile-form__row">
      <div class="edit-profile-form__row-title">About</div>
      <input
        v-model="profile.about"
        type="text"
        class="text-input text-input_flex_auto"
        placeholder="About"
      />
    </div>
    <hr class="divider" />
    <div class="edit-profile-form__buttons">
      <router-link :to="{ name: 'profile-view' }">
        <button role="link" class="button button_color_gray">Cancel</button>
      </router-link>
      <button class="button button_color_green" @click="updateProfile">
        Apply
      </button>
    </div>
    <div
      class="edit-profile-form__change-pass-title-row"
      @click="toggleIsPassFieldsShowed"
    >
      <div class="edit-profile-form__change-pas-title">
        Change your password
      </div>
      <span class="arrow" :class="{ active: isUpdatePassFormShown }"></span>
    </div>
    <transition name="fade">
      <b-update-password-form
        class="edit-profile-form__password-rows"
        v-if="isUpdatePassFormShown"
      />
    </transition>
    <transition name="slide-fade-vertical">
      <b-submit-modal
        v-if="isUpdateProfileSubmitModalShown"
        @accept="submitUpdateProfile"
        @decline="closeSubmitModal"
      />
    </transition>
  </div>
</template>

<script>
import { minLength, required } from "vuelidate/lib/validators";
import BSubmitModal from "@/components/BModal/BSubmitModal";
import BTextInput from "@/components/BTextInput";
import BUpdatePasswordForm from "@/components/BUpdatePasswordForm";

export default {
  name: "BEditProfileForm",
  components: {
    BTextInput,
    BSubmitModal,
    BUpdatePasswordForm,
  },
  data() {
    return {
      profile: { ...this.profileProps },
      isUpdateProfileSubmitModalShown: false,
      isUpdatePassFormShown: false,
    };
  },
  props: {
    profileProps: {
      type: Object,
      required: true,
    },
  },
  validations: {
    profile: {
      firstName: {
        required,
        minLength: minLength(2),
      },
      lastName: {
        required,
        minLength: minLength(2),
      },
    },
  },
  methods: {
    updateProfile() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.error("Please enter correct data");
        return;
      }

      this.showSubmitModal();
    },
    showSubmitModal() {
      this.isUpdateProfileSubmitModalShown = true;
    },
    closeSubmitModal() {
      this.isUpdateProfileSubmitModalShown = false;
    },
    submitUpdateProfile() {
      this.$emit("updateProfileInfo", this.profile);
      this.closeSubmitModal();
    },
    toggleIsPassFieldsShowed() {
      this.isUpdatePassFormShown = !this.isUpdatePassFormShown;
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/edit-profile-form"
</style>
