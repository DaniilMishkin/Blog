<template>
  <div class="avatar border-main">
    <img :src="imgSrc" class="avatar__img" alt="" />
    <hr class="divider" />
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "BAvatar",
  props: {
    imgSrc: {
      type: String,
      default: require("@/assets/images/no-photo.gif"),
    },
  },
};
</script>

<style scoped lang="sass">
@import "../assets/styles/blocks/avatar"
</style>
