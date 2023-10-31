<template>
  <div class="border-main create-post">
    <transition name="fade">
      <div v-show="!!previewImage" class="create-post__preview-img">
        <img :src="previewImage" alt="" />
        <img
          @click="resetPreview"
          class="preview-close"
          src="@/assets/icons/cross.svg"
          alt=""
        />
      </div>
    </transition>
    <div class="create-post__content">
      <b-text-input
        type="text"
        placeholder="Title"
        :validation-prop="$v.newPost.title"
        v-model.trim="newPost.title"
      />
      <div class="grow-wrap">
        <textarea
          v-model="newPost.text"
          placeholder="Text"
          onInput="this.parentNode.dataset.replicatedValue = this.value"
        />
      </div>
      <div class="create-post__buttons">
        <input
          class="pin-input"
          id="pin-input"
          type="file"
          @change="uploadPreviewImg"
        />
        <label for="pin-input">
          <img class="pin-button" src="@/assets/icons/pin-img.svg" alt="" />
        </label>
        <button @click="createNewPost" class="button button_color_green">
          Apply
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import BTextInput from "@/components/BTextInput";
import { maxLength, required } from "vuelidate/lib/validators";
import PostApi from "@/api/postApi";
import snakeCase from "lodash/snakeCase";

export default {
  name: "BCreatePost",
  components: { BTextInput },
  data() {
    return {
      newPost: {
        title: "",
        text: "",
        image: null,
      },
      previewImage: null,
    };
  },
  validations: {
    newPost: {
      title: {
        required,
        maxLength: maxLength(255),
      },
      text: {
        maxLength: maxLength(255),
      },
    },
  },
  methods: {
    async createNewPost() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.error(
          "I don't understand... Maybe you love MB, asshole?"
        );
        return;
      }

      if (!this.newPost.image) {
        this.$toasted.error("Please, choose the image");
        return;
      }

      try {
        const formData = new FormData();
        Object.keys(this.newPost)?.forEach((key) => {
          formData.append(snakeCase(key), this.newPost[key]);
        });

        const post = await PostApi.store(formData);
        this.$emit("createPost", post);

        this.resetForm();
        this.$toasted.success("Your post added");
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    uploadPreviewImg(event) {
      const file = event.target.files[0];
      this.previewImage = URL.createObjectURL(file);

      this.newPost.image = file;
    },
    resetPreview() {
      this.previewImage = null;
    },
    resetForm() {
      this.newPost = { image: null, title: "", text: "" };
      this.$v.newPost.$reset();
      this.resetPreview();
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/create-post.sass"
</style>
