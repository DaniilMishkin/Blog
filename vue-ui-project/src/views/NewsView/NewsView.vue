<template>
  <div class="main-wrapper">
    <div class="news-view">
      <b-search
        :options="options"
        :search="defaultSearch"
        @searchSort="handleSearchSort"
        @resetSort="handleResetSort"
      />
      <b-create-post @createPost="handleCreatePost" />
      <div class="news-view__posts">
        <b-post
          v-for="(post, index) in posts"
          :key="post.id"
          v-model="posts[index]"
          @deletePost="handleDeletePost"
        />
      </div>
      <infinite-loading
        :identifier="infiniteId"
        @infinite="infiniteLoadingHandler"
      />
    </div>
  </div>
</template>

<script>
import BCreatePost from "@/components/BCreatePost";
import BSearch from "@/components/BSearch";
import {
  NEW_FIRST_SORT_OPTION,
  NEWS_SORT_OPTIONS,
} from "@/views/NewsView/news-sort-config";
import PostApi from "@/api/postApi";
import { convertObjectKeys } from "@/api/apiHelpers";
import camelCase from "lodash/camelCase";
import { mapGetters } from "vuex";
import BPost from "@/components/BPost/BPost";

export default {
  name: "NewsView",
  components: { BPost, BCreatePost, BSearch },
  data() {
    return {
      defaultSearch: {
        searchString: null,
        sort: NEW_FIRST_SORT_OPTION,
      },
      sortSearchParams: {
        ...NEW_FIRST_SORT_OPTION.params,
        search: "",
      },
      infiniteId: +new Date(),
      options: NEWS_SORT_OPTIONS,
      posts: [],
      postsPage: 1,
    };
  },
  methods: {
    handleCreatePost(newPost) {
      this.posts.unshift(newPost);
    },
    handleDeletePost(id) {
      let index = this.posts.findIndex((post) => post.id === id);
      this.posts.splice(index, 1);
    },
    handleUpdatePost(updatedPost) {
      let index = this.posts.findIndex((post) => post.id === updatedPost.id);
      this.posts.splice(index, 1, updatedPost);
    },
    handleSearchSort(updatedSearch) {
      this.handleResetSort();

      this.sortSearchParams = {
        ...updatedSearch.sort.params,
        search: updatedSearch.searchString,
      };
    },
    handleResetSort() {
      this.sortSearchParams = {
        ...NEW_FIRST_SORT_OPTION.params,
        search: "",
      };
      this.posts = [];
      this.infiniteId += 1;
      this.postsPage = 1;
    },
    async fetchUserNews(paramsConfig) {
      try {
        paramsConfig = {
          ...paramsConfig,
          userNews: true,
          page: this.postsPage,
        };
        return await PostApi.index(paramsConfig);
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    async infiniteLoadingHandler($state) {
      const data = await this.fetchUserNews(this.sortSearchParams);

      if (data.length) {
        this.postsPage += 1;
        this.posts.push(...data);
        $state.loaded();
      } else {
        $state.complete();
      }
    },
    listenPostsEvents() {
      window.Echo.channel("posts")
        .listen("CreatePost", ({ data }) => {
          data = convertObjectKeys(data, camelCase);

          this.handleCreatePost(data);
        })
        .listen("UpdatePost", ({ data }) => {
          data = convertObjectKeys(data, camelCase);

          this.handleUpdatePost(data);
        })
        .listen("DeletePost", ({ post_id }) => {
          let index = this.posts.findIndex((post) => post.id === post_id);

          this.posts.splice(index, 1);
        });
    },
  },
  computed: {
    ...mapGetters({
      loggedUser: "loggedUser",
    }),
  },
  mounted() {
    this.listenPostsEvents();
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/pages/news.sass"
</style>
