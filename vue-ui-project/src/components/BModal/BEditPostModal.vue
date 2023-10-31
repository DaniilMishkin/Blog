<template>
  <b-modal @closeModal="closeModal">
    <div class="edit-post-modal border-main">
      <img
        class="edit-post-modal_close-icon"
        @click="closeModal"
        src="@/assets/icons/cross.svg"
        alt=""
      />
      <label for="img-input">
        <img :src="previewImage" alt="" class="edit-post-modal__img" />
      </label>
      <input
        @change="handleChangeImg"
        id="img-input"
        type="file"
        class="edit-post-modal__hidden-input"
      />
      <b-text-input
        type="text"
        placeholder="Title"
        :validation-prop="$v.postCopy.title"
        v-model.trim="postCopy.title"
      />
      <div class="grow-wrap">
        <textarea
          v-model="postCopy.text"
          placeholder="Text"
          onInput="this.parentNode.dataset.replicatedValue = this.value"
        />
      </div>
      <div class="edit-post-modal__footer">
        <button @click="closeModal" class="button button_color_gray">
          Cancel
        </button>
        <button @click="handleApplyChanges" class="button button_color_green">
          Apply
        </button>
      </div>
    </div>
  </b-modal>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import { maxLength, required } from "vuelidate/lib/validators";
import BTextInput from "@/components/BTextInput";
import BModal from "@/components/BModal/BModal";
import PostApi from "@/api/postApi";
import snakeCase from "lodash/snakeCase";

export default {
  mixins: [clickaway],
  name: "BEditModal",
  components: {
    BTextInput,
    BModal,
  },
  data() {
    return {
      postCopy: { ...this.post },
      previewImage: this.post.image,
    };
  },
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
  validations: {
    postCopy: {
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
    closeModal() {
      this.$emit("closeModal");
    },
    async handleApplyChanges() {
      this.$v.$touch();

      if (this.$v.$invalid) {
        this.$toasted.error("Please enter correct data");
        return;
      }

      try {
        const formData = new FormData();

        Object.keys(this.postCopy)?.forEach((key) => {
          formData.append(snakeCase(key), this.postCopy[key]);
        });
        formData.append("_method", "PUT");

        const updatedPost = await PostApi.update(this.postCopy.id, formData);

        this.$emit("applyChanges", updatedPost);
        this.closeModal();
        this.$toasted.success("Changes saved");
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    handleChangeImg(event) {
      const file = event.target?.files?.[0];
      this.previewImage = URL.createObjectURL(file);

      this.postCopy.image = file;
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/modals/edit-post-modal.sass"
</style>
