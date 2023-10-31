import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import Vuelidate from "vuelidate";
import Toasted from "vue-toasted";
import "@/assets/styles/main.sass";
import InfiniteLoading from "vue-infinite-loading";
import Echo from "laravel-echo";
import NoMore from "@/components/InfiniteLoading/NoMore";
import NoResults from "@/components/InfiniteLoading/NoResults";

window.io = require("socket.io-client");
window.Echo = new Echo({
  broadcaster: "socket.io",
  host: process.env.VUE_APP_ECHO_URL,
});

Vue.use(InfiniteLoading, {
  slots: {
    noResults: NoResults,
    noMore: NoMore,
  },
});

Vue.config.productionTip = false;

Vue.use(Vuelidate);
Vue.use(Toasted, {
  theme: "bubble",
  duration: 2500,
});

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
