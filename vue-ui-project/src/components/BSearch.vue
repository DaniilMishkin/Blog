<template>
  <div class="search">
    <div class="search-post border-main">
      <input
        type="text"
        class="search-post__input text-input"
        placeholder="Search"
        v-model="searchCopy.searchString"
      />
      <button
        class="button button_color_green"
        @click="$emit('searchSort', searchCopy)"
      >
        Search
      </button>
    </div>
    <div class="search__sort">
      <multiselect
        v-model="searchCopy.sort"
        :options="options"
        :object="true"
        :searchable="false"
        :close-on-select="true"
        :show-labels="false"
        label="label"
        track-by="id"
        placeholder="Sort"
      />
      <button @click="resetSearchSort" class="button button_color_gray">
        Reset
      </button>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
  name: "BSearch",
  components: { Multiselect },
  data() {
    return {
      searchCopy: { ...this.search },
    };
  },
  props: {
    search: {
      type: Object,
      default: () => {
        return {
          searchString: null,
          sort: "",
        };
      },
    },
    options: {
      type: Array,
    },
  },
  methods: {
    resetSearchSort() {
      this.searchCopy = {
        searchString: null,
        sort: this.search.sort,
      };
      this.$emit("resetSort");
    },
  },
  watch: {
    "searchCopy.sort"() {
      this.$emit("searchSort", this.searchCopy);
    },
  },
};
</script>

<style scoped>
@import "../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";

.multiselect {
  width: 100%;
}
</style>

<style scoped lang="sass">
@import "@/assets/styles/blocks/search.sass"
</style>
