<template>
  <div class="header-menu-button" @click="$emit('toggleMenu')">
    <img :src="avatar" alt="" class="header-menu-button__avatar" />
    <div
      class="header-menu-button__icon"
      :class="{ 'header-menu-button__icon_active': isMenuActive }"
    >
      <span class="header-menu-button__icon-span" />
    </div>
  </div>
</template>

<script>
export default {
  name: "BHeaderMenuButton",
  props: {
    avatar: {
      type: String,
      default: require("@/assets/images/no-photo.gif"),
    },
    isMenuActive: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/header/header-menu-button.sass"
</style>
