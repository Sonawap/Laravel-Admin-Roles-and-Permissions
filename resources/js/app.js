require('./bootstrap');

window.Vue = require('vue');
window.Fire = new Vue();
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.component('role', require('./components/role.vue').default);

const app = new Vue({
    el: '#app'
});
