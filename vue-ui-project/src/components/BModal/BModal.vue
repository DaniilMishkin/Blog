<template>
  <div class="modal">
    <div v-on-clickaway="closeModal" class="close-away">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import { toggleOverflow } from "@/helpers/toggleOverflow";

export default {
  name: "BModal",
  mixins: [clickaway],
  methods: {
    closeModal() {
      this.$emit("closeModal");
    },
  },
  mounted() {
    toggleOverflow();
  },
  destroyed() {
    toggleOverflow();
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/modals/modal.sass"
</style>
