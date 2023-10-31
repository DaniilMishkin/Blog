<template>
  <div class="main-wrapper">
    <div class="profile-view">
      <div class="profile-view__content">
        <div class="profile-view__info">
          <b-avatar :img-src="profile.avatar">
            <router-link
              v-if="isOwner"
              :to="{ name: 'edit-profile-view' }"
              castom
              v-slot="{ navigate }"
            >
              <button
                class="avatar__edit-button button button_color_blue"
                @click="navigate"
                role="link"
              >
                Edit
              </button>
            </router-link>
            <b-subscribe-button :key="profile.id" v-else :member="profile" />
          </b-avatar>
          <b-profile-information :profile="profile" />
        </div>
        <b-create-post v-if="isOwner" @createPost="handleCreatePost" />
        <div class="profile__posts">
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
  </div>
</template>

<script>
import BProfileInformation from "@/components/BProfileInformation";
import BSubscribeButton from "@/components/BSubscribeButton";
import BCreatePost from "@/components/BCreatePost";
import BAvatar from "@/components/BAvatar";
import BPost from "@/components/BPost/BPost";
import PostApi from "@/api/postApi";
import UsersApi from "@/api/usersApi";
import { mapGetters } from "vuex";

export default {
  name: "ProfileView",
  components: {
    BProfileInformation,
    BCreatePost,
    BAvatar,
    BPost,
    BSubscribeButton,
  },
  data() {
    return {
      posts: [],
      profile: {},
      postsPage: 1,
      infiniteId: +new Date(),
    };
  },
  methods: {
    async fetchUserPosts() {
      try {
        return await PostApi.index({
          filterByUserId: this.$route.params.id,
          sortByDate: "desc",
          page: this.postsPage,
        });
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    async fetchUser() {
      try {
        this.profile = await UsersApi.show(this.$route.params.id);
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    handleCreatePost(newPost) {
      this.posts.unshift(newPost);
    },
    handleDeletePost(id) {
      let index = this.posts.findIndex((post) => post.id === id);
      this.posts.splice(index, 1);
    },
    async infiniteLoadingHandler($state) {
      const data = await this.fetchUserPosts();

      if (data.length) {
        this.postsPage += 1;
        this.posts.push(...data);
        $state.loaded();
      } else {
        $state.complete();
      }
    },
  },
  computed: {
    ...mapGetters({
      loggedUser: "loggedUser",
    }),
    isOwner() {
      return +this.$route.params.id === this.loggedUser.id;
    },
  },
  created() {
    this.$watch(
      () => this.$route.params,
      () => {
        this.fetchUser();
        this.infiniteId += 1;
        this.postsPage = 1;
        this.posts = [];
      },
      { immediate: true }
    );
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/pages/profile"
</style>
