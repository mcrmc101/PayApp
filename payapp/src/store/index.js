import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import * as Cookies from 'js-cookie'

Vue.use(Vuex)

export default new Vuex.Store({
  plugins: [createPersistedState({
    storage: {
      getItem: (key) => Cookies.get(key),
      // Please see https://github.com/js-cookie/js-cookie#json, on how to handle JSON.
      setItem: (key, value) =>
        Cookies.set(key, value, { expires: 365, secure: true }),
      removeItem: (key) => Cookies.remove(key)
    }
  })],
  state: {
    userToken: '',
    isUser: false
  },
  mutations: {
    setUserToken (state, val) {
      state.userToken = val
    },
    setIsUser (state, val) {
      state.isUser = val
    }
  },
  actions: {
  },
  modules: {
  }
})
