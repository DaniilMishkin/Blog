<template>
  <img
    @click="toggleIsLikePressed"
    class="likes__icon"
    :src="require(`@/assets/icons/${iconSrc}`)"
    alt=""
  />
</template>

<script>
import PostApi from "@/api/postApi";

export default {
  name: "BPostLikeIcon",
  model: {
    prop: "post",
    event: "updatePost",
  },
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
  methods: {
    async toggleIsLikePressed() {
      try {
        await PostApi.toggleLike(this.postInnerValue.id);

        this.postInnerValue.likesCount = this.postInnerValue.isLikePressed
          ? --this.postInnerValue.likesCount
          : ++this.postInnerValue.likesCount;

        this.postInnerValue.isLikePressed = !this.postInnerValue.isLikePressed;
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
  },
  computed: {
    postInnerValue: {
      get: function () {
        return this.post;
      },
      set: function (value) {
        this.$emit("updatePost", value);
      },
    },
    iconSrc() {
      return this.postInnerValue.isLikePressed
        ? "like-button-pressed.svg"
        : "like-button.svg";
    },
  },
};
</script>
