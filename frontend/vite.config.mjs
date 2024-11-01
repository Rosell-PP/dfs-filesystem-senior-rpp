// Plugins
import Components from 'unplugin-vue-components/vite'
import Vue from '@vitejs/plugin-vue'
import Vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'
import ViteFonts from 'unplugin-fonts/vite'

// Utilities
import { defineConfig } from 'vite'
import { fileURLToPath, URL } from 'node:url'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    Vue({
      template: { transformAssetUrls }
    }),
    // https://github.com/vuetifyjs/vuetify-loader/tree/master/packages/vite-plugin#readme
    Vuetify(),
    Components(),
    ViteFonts({
      google: {
        families: [{
          name: 'Roboto',
          styles: 'wght@100;300;400;500;700;900',
        }],
      },
    }),
  ],
  define: { 'process.env': {
    "VUE_APP_PUSHER_APP_ID":"dfs-filesystem-pusher-app",
    "VUE_APP_PUSHER_APP_KEY":"dfs-filesystem",
    "VUE_APP_PUSHER_APP_SECRET":"1QAZ2wd$rv^hbgg286**/jnvfc5%$*$",
    "VUE_APP_PUSHER_HOST":"soketi",
    "VUE_APP_PUSHER_PORT":6001,
    "VUE_APP_PUSHER_SCHEME":"http",
    "VUE_APP_PUSHER_APP_CLUSTER":"mt1",
  } },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
    extensions: [
      '.js',
      '.json',
      '.jsx',
      '.mjs',
      '.ts',
      '.tsx',
      '.vue',
    ],
  },
  server: {
    port: 3000,
  },
})
