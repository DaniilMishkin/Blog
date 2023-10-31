<template>
  <b-modal @closeModal="$emit('decline')">
    <div class="submit-modal border-main">
      <div class="submit-modal__text">{{ helpText }}</div>
      <div class="submit-modal__buttons">
        <button @click="$emit('decline')" class="button button_color_gray">
          Decline
        </button>
        <button @click="$emit('accept')" class="button button_color_green">
          Accept
        </button>
      </div>
    </div>
  </b-modal>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import BModal from "@/components/BModal/BModal";

export default {
  mixins: [clickaway],
  name: "BSubmitModal",
  components: { BModal },
  props: {
    helpText: {
      type: String,
      default: "Are you sure?",
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/modals/submit-modal.sass"
</style>
