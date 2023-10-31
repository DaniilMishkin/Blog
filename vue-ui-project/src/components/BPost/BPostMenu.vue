<template>
  <div v-on-clickaway="closePostMenu" class="post-menu">
    <img
      @click="togglePostMenu"
      class="post-menu__edit-button"
      src="@/assets/icons/edit-button.svg"
      alt=""
    />
    <div v-show="isPostMenuShowed" class="post-menu__menu-list">
      <div @click="$emit('editPost')" class="menu-list__item">Edit</div>
      <div @click="$emit('deletePost')" class="menu-list__item">Delete</div>
    </div>
  </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";

export default {
  name: "BPostMenu",
  mixins: [clickaway],
  data() {
    return {
      isPostMenuShowed: false,
    };
  },
  methods: {
    togglePostMenu() {
      this.isPostMenuShowed = !this.isPostMenuShowed;
    },
    closePostMenu() {
      this.isPostMenuShowed = false;
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/posts/post-menu.sass"
</style>
