<template>
  <div class="main-wrapper">
    <div class="members-view">
      <b-search
        :options="options"
        :search="defaultSearch"
        @searchSort="handleSearchSort"
        @resetSort="handleResetSort"
      />
      <b-member-list
        @infinite="infiniteLoadingHandler"
        :infinite-id="infiniteId"
        :members="members"
      />
    </div>
  </div>
</template>

<script>
import BMemberList from "@/components/BMemberList";
import BSearch from "@/components/BSearch";
import { MEMBERS_SORT_OPTIONS } from "@/views/MemberView/members-sort-config";
import UsersApi from "@/api/usersApi";

export default {
  name: "MembersView",
  components: {
    BMemberList,
    BSearch,
  },
  data() {
    return {
      options: MEMBERS_SORT_OPTIONS,
      defaultSearch: {
        searchString: "",
        sort: "",
      },
      sortSearchParams: null,
      members: [],
      infiniteId: +new Date(),
      membersPage: 1,
    };
  },
  methods: {
    async fetchUsers(params) {
      try {
        return await UsersApi.index(params);
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    handleSearchSort(updatedSearch) {
      this.handleResetSort();

      this.sortSearchParams = {
        ...updatedSearch.sort.params,
        search: updatedSearch.searchString,
      };
    },
    handleResetSort() {
      this.sortSearchParams = {};
      this.members = [];
      this.infiniteId += 1;
      this.membersPage = 1;
    },
    async infiniteLoadingHandler($state) {
      const data = await this.fetchUsers({
        ...this.sortSearchParams,
        page: this.membersPage,
      });

      if (data.length) {
        this.membersPage += 1;
        this.members.push(...data);
        $state.loaded();
      } else {
        $state.complete();
      }
    },
  },
};
</script>

<style scoped lang="sass">
.members-view
  width: 100%
</style>
