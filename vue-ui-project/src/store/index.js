import Vue from "vue";
import Vuex from "vuex";
import AuthApi from "@/api/auth";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loggedUser: null,
  },
  getters: {
    loggedUser(state) {
      return state.loggedUser;
    },
  },
  mutations: {
    updateProfile(state, newProfile) {
      state.loggedUser = newProfile;
    },
  },
  actions: {
    async setLoggedUser(context) {
      try {
        context.commit("updateProfile", await AuthApi.me());
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
    async logout(context) {
      try {
        await AuthApi.logout();
        context.commit("updateProfile", null);
      } catch (error) {
        this.$toasted.error(error.response.data.message);
      }
    },
  },
});
