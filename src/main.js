// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import './firebase'
import Vue from 'vue'
import App from './App'
import router from './router'
import VueFire from 'vuefire'
import BootstrapVue from 'bootstrap-vue'
import moment from 'moment'
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.prototype.moment = moment
Vue.config.productionTip = false
Vue.use(VueFire);
Vue.use(BootstrapVue);
Vue.use(require('vue-moment'));

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
