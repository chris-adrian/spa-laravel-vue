require('./bootstrap');

import Vue from 'vue'
import App from './App.vue'
import Router  from './router'
import Store from './store'
import Axios from 'axios'
import VueHead from 'vue-head'
import VCalendar from 'v-calendar';

Vue.use(VueHead);
Vue.use(VCalendar, {
  componentPrefix: 'vc', 
  locales: {
    'dob-locale': {
      masks: {
        L: 'YYYY-MM-DD'
      }
    }
  }
});
Vue.config.productionTip = false;
/**
 * Important : Set base URL first
 */
Axios.defaults.baseURL = 'http://localhost:8000/api/';


/**
 * Set Token
 */
Store.subscribe((mutation)=> {
  switch (mutation.type) {
    case 'auth/SET_TOKEN':
      if (mutation.payload) {
        Axios.defaults.headers.common['Authorization'] = `Bearer ${mutation.payload}`; 
        localStorage.setItem('token', mutation.payload);
      } else {
        Axios.defaults.headers.common['Authorization'] = null;
        localStorage.removeItem('token');
      }
      break;
  }
})
/**
 * Fetch & Render
 */
Store.dispatch('auth/attempt', localStorage.getItem('token')).then(()=>{
  new Vue({
    el: '#app',
    router: Router,
    store: Store,
    render: h => h(App)
  });
});  




