<template>
  <div v-on-clickaway="closeMenu">
    <b-header-menu-button
      :avatar="loggedUser.avatar"
      :is-menu-active="isMenuActive"
      @toggleMenu="toggleMenu"
    />
    <transition name="slide-fade-horizontal">
      <div class="header-drop-menu" v-show="isMenuActive">
        <b-header-drop-menu-item
          v-for="menuItem in menuItems"
          :key="menuItem.id"
          :logged-user="loggedUser"
          :menu-item="menuItem"
        />
      </div>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { mixin as clickaway } from "vue-clickaway";
import BHeaderMenuButton from "@/components/BHeader/BHeaderMenuButton";
import BHeaderDropMenuItem from "@/components/BHeader/BHeaderDropMenuItem";

export default {
  name: "BDropMenu",
  components: {
    BHeaderMenuButton,
    BHeaderDropMenuItem,
  },
  mixins: [clickaway],
  data() {
    return {
      menuItems: [
        {
          title: "Profile",
          id: 1,
          iconSrc: require("@/assets/icons/profile.svg"),
          routeName: "profile-view",
          handler: this.toggleMenu,
        },
        {
          title: "News",
          id: 2,
          iconSrc: require("@/assets/icons/news.svg"),
          routeName: "news-view",
          handler: this.toggleMenu,
        },
        {
          title: "People",
          id: 3,
          iconSrc: require("@/assets/icons/people.svg"),
          routeName: "members-view",
          handler: this.toggleMenu,
        },
        {
          title: "Settings",
          id: 4,
          iconSrc: require("@/assets/icons/settings.svg"),
          routeName: "edit-profile-view",
          handler: this.toggleMenu,
        },
        {
          title: "Log out",
          id: 5,
          iconSrc: require("@/assets/icons/log-out.svg"),
          routeName: "login-view",
          handler: this.handleLogout,
        },
      ],
      isMenuActive: false,
    };
  },
  methods: {
    ...mapActions({
      logout: "logout",
    }),
    closeMenu() {
      this.isMenuActive = false;
    },
    toggleMenu() {
      this.isMenuActive = !this.isMenuActive;
    },
    async handleLogout() {
      await this.logout();
      this.$toasted.success("Goodbye");
    },
  },
  computed: {
    ...mapGetters({
      loggedUser: "loggedUser",
    }),
  },
};
</script>

<style scoped lang="sass">
@import "@/assets/styles/blocks/header/header-drop-menu.sass"
</style>
