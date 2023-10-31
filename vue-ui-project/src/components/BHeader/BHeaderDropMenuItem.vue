<template>
  <router-link
    :to="{ name: menuItem.routeName, params: { id: loggedUser.id } }"
  >
    <div @click="menuItem.handler" role="link" class="header-drop-menu-item">
      <div class="header-drop-menu-item__title">
        {{ menuItem.title }}
      </div>
      <img :src="menuItem.iconSrc" class="header-drop-menu-item__icon" alt="" />
    </div>
  </router-link>
</template>

<script>
export default {
  name: "BHeaderDropMenuItem",
  props: {
    menuItem: {
      type: Object,
      required: true,
    },
    loggedUser: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/header/header-drop-menu-item.sass"
</style>
