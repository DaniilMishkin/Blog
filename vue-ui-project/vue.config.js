const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  transpileDependencies: true,
  css: {
    loaderOptions: {
      sass: {
        additionalData: `
            @import "~@/assets/styles/variables/colors.sass"
            @import "~@/assets/styles/mixins/media-request.sass"
        `,
      },
    },
  },
});
