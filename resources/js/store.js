import Vue from 'vue'
import Vuex from 'vuex'
import auth from './store/auth'
import user from './store/user'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
    },
    mutations: {
    },
    actions: {
    },
    modules: {
        auth,
        user
    }
})

export default store