<template>
  <button
    @click="toggleSubscribeButton"
    :class="[
      'button',
      memberCopy.isFollowing ? 'button_color_gray' : 'button_color_blue',
    ]"
  >
    {{ memberCopy.isFollowing ? "Unsubscribe" : "Subscribe" }}
  </button>
</template>

<script>
import SubscriptionApi from "@/api/subscriptionApi";

export default {
  name: "BSubscribeButton",
  data() {
    return {
      memberCopy: { ...this.member },
    };
  },
  props: {
    member: {
      type: Object,
      required: true,
    },
  },
  methods: {
    async toggleSubscribeButton() {
      try {
        await SubscriptionApi.toggleSubscribe(this.memberCopy.id);
        this.memberCopy.isFollowing = !this.memberCopy.isFollowing;
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
  },
};
</script>
