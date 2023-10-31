<template>
  <div class="border-main profile-info">
    <div class="profile-info__header">{{ profile.fullName }}</div>
    <hr class="divider" />
    <div class="profile-info__content">
      <div class="content-row">
        <div class="profile-info__title">About</div>
        <div class="profile-info__text">{{ profile.about }}</div>
      </div>
    </div>
    <hr class="divider" />
    <div class="profile-info__footer">
      <div class="subs-count" @click="openSubsModal('getUserSubscribers')">
        <div class="subs-count__title">Subscribers</div>
        <div class="subs-count__value">{{ profile.subscribersCount }}</div>
      </div>
      <div class="subs-count" @click="openSubsModal('getUserSubscriptions')">
        <div class="subs-count__title">Subscriptions</div>
        <div class="subs-count__value">{{ profile.subscriptionsCount }}</div>
      </div>
    </div>
    <b-modal v-if="isSubsModalShown" @closeModal="closeModal">
      <b-member-list
        @infinite="infiniteLoadingHandler"
        :infinite-id="infiniteId"
        :members="subsList"
      />
    </b-modal>
  </div>
</template>

<script>
import BModal from "@/components/BModal/BModal";
import BMemberList from "@/components/BMemberList";
import SubscriptionApi from "@/api/subscriptionApi";

export default {
  name: "BProfileInformation",
  components: { BModal, BMemberList },
  data() {
    return {
      subsList: [],
      isSubsModalShown: false,
      infiniteId: +new Date(),
      membersPage: 1,
      infiniteData: null,
      subsFetchMethod: "getUserSubscribers",
    };
  },
  props: {
    profile: {
      type: Object,
      required: true,
    },
  },
  methods: {
    async infiniteLoadingHandler($state) {
      this.infiniteData = await SubscriptionApi[this.subsFetchMethod](
        this.$route.params.id,
        {
          page: this.membersPage,
        }
      );

      if (this.infiniteData.length) {
        this.membersPage += 1;
        this.subsList.push(...this.infiniteData);
        $state.loaded();
      } else {
        $state.complete();
      }
    },
    openSubsModal(method) {
      this.isSubsModalShown = true;
      this.subsFetchMethod = method;
    },
    closeModal() {
      this.infiniteId += 1;
      this.isSubsModalShown = false;
      this.subsList = [];
      this.membersPage = 1;
    },
  },
  watch: {
    "$route.params"() {
      this.closeModal();
    },
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/profile-info.sass"
</style>
