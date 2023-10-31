<template>
  <div class="header">
    <div class="header-logo">
      <img
        class="header-logo__icon"
        src="@/assets/icons/logo-icon.svg"
        alt=""
      />
      <div class="header-logo__text">BimmerBlog</div>
    </div>
    <b-header-drop-menu />
  </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import BHeaderDropMenu from "@/components/BHeader/BHeaderDropMenu";

export default {
  name: "BHeader",
  mixins: [clickaway],
  components: { BHeaderDropMenu },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/header/header.sass"
</style>
