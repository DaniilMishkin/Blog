<template>
  <div class="border-main post">
    <div class="post-header">
      <div class="post-header__author">
        <img
          :src="postInnerValue.user.avatar ?? '@/assets/images/no-photo.gif'"
          alt=""
          class="author__avatar"
        />
        <div class="author__nickname">{{ postInnerValue.user.fullName }}</div>
      </div>
      <b-post-menu
        v-if="isOwner"
        @editPost="togglePostEditModal"
        @deletePost="togglePostDeleteSubmitModal"
      />
    </div>
    <div class="post-content">
      <img
        :src="postInnerValue.image ?? '@/assets/images/no-photo.gif'"
        alt=""
        class="post-content__img"
      />
      <div class="post-content__title">{{ postInnerValue.title }}</div>
      <pre class="post-content__main-text">{{ postInnerValue.text }}</pre>
    </div>
    <div class="post-footer">
      <div class="post-footer__likes">
        <b-post-like-icon v-model="postInnerValue" />
        <div class="likes__count">{{ postInnerValue.likesCount }}</div>
      </div>
      <div class="post-footer__date">{{ postDate }}</div>
    </div>
    <b-edit-modal
      :post="postInnerValue"
      v-if="isEditModalShowed"
      @closeModal="togglePostEditModal"
      @applyChanges="handleApplyChanges"
    />
    <transition name="slide-fade-vertical">
      <b-submit-modal
        help-text="Are you sure you want to delete the post?"
        v-if="isPostDeleteSubmitModalShown"
        @decline="togglePostDeleteSubmitModal"
        @accept="removePost"
      />
    </transition>
  </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import BEditModal from "@/components/BModal/BEditPostModal";
import BSubmitModal from "@/components/BModal/BSubmitModal";
import BPostMenu from "@/components/BPost/BPostMenu";
import BPostLikeIcon from "@/components/BPost/BPostLikeIcon";
import PostApi from "@/api/postApi";
import dayjs from "dayjs";
import { mapGetters } from "vuex";

export default {
  mixins: [clickaway],
  name: "BPost",
  components: { BEditModal, BSubmitModal, BPostMenu, BPostLikeIcon },
  model: {
    prop: "post",
    event: "updatePost",
  },
  data() {
    return {
      isEditModalShowed: false,
      isPostDeleteSubmitModalShown: false,
    };
  },
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
  methods: {
    togglePostEditModal() {
      this.isEditModalShowed = !this.isEditModalShowed;
    },
    togglePostDeleteSubmitModal() {
      this.isPostDeleteSubmitModalShown = !this.isPostDeleteSubmitModalShown;
    },
    handleApplyChanges(newPost) {
      this.postInnerValue = newPost;
    },
    async removePost() {
      try {
        await PostApi.delete(this.postInnerValue.id);

        this.$emit("deletePost", this.postInnerValue.id);
        this.togglePostDeleteSubmitModal();

        this.$toasted.success("Post deleted!!!");
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
  },
  computed: {
    ...mapGetters({
      loggedUser: "loggedUser",
    }),
    postInnerValue: {
      get: function () {
        return this.post;
      },
      set: function (value) {
        this.$emit("updatePost", value);
      },
    },
    postDate() {
      const dateFormat = "DD MMM, HH:mm:ss";

      return this.postInnerValue.updatedAt === this.postInnerValue.createdAt
        ? dayjs(this.postInnerValue.createdAt).format(dateFormat)
        : "updated, " + dayjs(this.postInnerValue.createdAt).format(dateFormat);
    },
    isOwner() {
      return this.postInnerValue.user.id === this.loggedUser.id;
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/posts/post.sass"
</style>
