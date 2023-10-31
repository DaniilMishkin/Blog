<template>
  <div class="main-wrapper">
    <div class="edit-profile">
      <b-avatar :img-src="previewImage">
        <input
          @change="uploadPreviewFile"
          id="input"
          type="file"
          class="edit-profile__input"
        />
        <label for="input">
          <div class="avatar__edit-button button button_color_blue">
            Upload new
          </div>
        </label>
      </b-avatar>
      <b-edit-profile-form
        :profile-props="loggedUser"
        @updateProfileInfo="handleUpdateProfileInfo"
      />
    </div>
  </div>
</template>

<script>
import BAvatar from "@/components/BAvatar";
import BEditProfileForm from "@/components/BEditProfileForm";
import { mapGetters, mapMutations } from "vuex";
import UsersApi from "@/api/usersApi";
import router from "@/router";
import snakeCase from "lodash/snakeCase";

export default {
  name: "EditProfileView",
  components: {
    BAvatar,
    BEditProfileForm,
  },
  data() {
    return {
      previewImage: this.$store.state.loggedUser.avatar,
      file: null,
    };
  },
  methods: {
    ...mapMutations({
      updateProfile: "updateProfile",
    }),
    uploadPreviewFile(event) {
      const file = event.target.files[0];
      this.previewImage = URL.createObjectURL(file);

      this.file = file;
    },
    async handleUpdateProfileInfo(newProfile) {
      try {
        newProfile.avatar = this.file;

        const formData = new FormData();
        Object.keys(newProfile)?.forEach((key) => {
          formData.append(snakeCase(key), newProfile[key]);
        });
        formData.append("_method", "PUT");

        const updatedUser = await UsersApi.update(newProfile.id, formData);

        this.updateProfile(updatedUser);

        await router.push({ name: "profile-view" });
        this.$toasted.success("Changes saved");
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
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
@import "@/assets/styles/pages/edit-profile.sass"
</style>
