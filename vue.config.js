const { defineConfig } = require('@vue/cli-service');

module.exports = defineConfig({
  transpileDependencies: true,
  outputDir: 'productimp/classes/Visualization/dist/',
  filenameHashing: false,
});
