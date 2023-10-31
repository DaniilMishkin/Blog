<template>
  <div class="member border-main">
    <img
      class="member__avatar"
      @click="goToMemberProfile"
      :src="member.avatar ?? '@/assets/images/no-photo.gif'"
      alt=""
    />
    <div class="member__nickname">{{ member.fullName }}</div>
    <b-subscribe-button v-if="!isOwner" :member="member" />
  </div>
</template>

<script>
import BSubscribeButton from "@/components/BSubscribeButton";
import router from "@/router";
import { mapGetters } from "vuex";

export default {
  name: "BMember",
  components: { BSubscribeButton },
  props: {
    member: {
      type: Object,
      required: true,
    },
  },
  methods: {
    goToMemberProfile() {
      router.push({ name: "profile-view", params: { id: this.member.id } });
    },
  },
  computed: {
    ...mapGetters({
      loggedUser: "loggedUser",
    }),
    isOwner() {
      return this.loggedUser.id === this.member.id;
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/members/member.sass"
</style>
