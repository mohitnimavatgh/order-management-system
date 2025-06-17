// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },

  runtimeConfig: {
    public: {
      api: 'http://127.0.0.1:8000/api'
    }
  },

  modules: ['@nuxtjs/tailwindcss']
})