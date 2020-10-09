require('./bootstrap');
window.Vue = require('vue');
window.Fire = new Vue()
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import {Form, HasError, AlertError} from 'vform';
window.toast = toast;

window.Form = Form;
import moment from 'moment'
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
});

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#e1e814',
    failedColor: 'red',
    height: '10px'

})


import VueCroppie from 'vue-croppie';
import 'croppie/croppie.css' // import the croppie css manually

Vue.use(VueCroppie);

// import VueToastr from "vue-toastr";
// Vue.use(VueToastr, {
//     defaultTimeout: 3000,
//     defaultProgressBar: false,
//     defaultProgressBarValue: 0,
//     defaultType: "success",
//     defaultPosition: "toast-bottom-full-width",
//     defaultCloseOnHover: false,
// });

// import { VuejsDatatableFactory } from 'vuejs-datatable';

// Vue.use( VuejsDatatableFactory );
import numeral from 'numeral';

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase()+ text.slice(1);
});

Vue.filter('firstChart', function(text){
    return text.charAt(0);
});

Vue.filter('up', function(text){
    return text.toUpperCase();
});

Vue.filter('currency', function(text){
    var number = numeral(text);

    return "₦" + number.format('0,0.00');

})

Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY, h:mma');
})

Vue.filter('timeAgo', function(created){
    return moment(created).startOf('hour').fromNow();
})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('dashboard', require('./components/dashboard.vue').default);

Vue.component('loading', require('./components/loading.vue').default);

Vue.component('role', require('./components/role.vue').default);

Vue.component('editrole', require('./components/editrole.vue').default);

Vue.component('user', require('./components/user.vue').default);

Vue.component('upload', require('./components/upload.vue').default);

Vue.component('notifications', require('./components/notifications.vue').default);

const app = new Vue({
    el: '#app',
});
