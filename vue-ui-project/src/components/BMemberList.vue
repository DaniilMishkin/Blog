<template>
  <div class="member-list">
    <b-member v-for="member in members" :key="member.id" :member="member" />
    <infinite-loading :identifier="infiniteId" @infinite="handleInfinite" />
  </div>
</template>

<script>
import BMember from "@/components/BMember";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "BMemberList",
  components: { BMember, InfiniteLoading },
  props: {
    members: {
      type: Array,
      required: true,
    },
    infiniteId: {
      type: Number,
      default: +new Date(),
    },
  },
  methods: {
    handleInfinite($state) {
      this.$emit("infinite", $state);
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/members/member-list.sass"
</style>
