<template>
  <div>
    <b-header />
    <router-view></router-view>
  </div>
</template>

<script>
import BHeader from "@/components/BHeader/BHeader";

export default {
  name: "BMainLayout",
  components: { BHeader },
};
</script>
