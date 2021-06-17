/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// Vue.config.silent = true;

// Vue.config.debug = false;
// Vue.config.devtools = false;
// Vue.config.productionTip=false;
// Vue.config.errorHandler = function (err, vm, info) {
//     // handle error
//     // `info` is a Vue-specific error info, e.g. which lifecycle hook
//     // the error was found in. Only available in 2.2.0+
//   }
//   Vue.config.warnHandler = function (msg, vm, trace) {
//     // `trace` is the component hierarchy trace
//   }
require('./bootstrap');

window.Vue = require('vue');
// Vue.config.silent = true;


import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;


  window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router';
Vue.use(VueRouter)
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })


let routes = [
    { path: '/home', component: require('./components/user/home.vue').default },
    { path: '/user', component: require('./components/admin/userManage.vue').default },
    { path: '/worker', component: require('./components/admin/workerManage.vue').default },
    { path: '/product', component: require('./components/admin/product.vue').default },
    { path: '/order', component: require('./components/admin/order.vue').default },
    { path: '/button', component: require('./components/admin/elements/button.vue').default },
    { path: '/boitier', component: require('./components/admin/elements/boitier.vue').default },
    { path: '/connection', component: require('./components/admin/elements/connection.vue').default },
    { path: '/ampere', component: require('./components/admin/elements/ampere.vue').default },
    { path: '/moderator', component: require('./components/moderator/display-admin.vue').default },
    { path: '/profile', component: require('./components/moderator/profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },

  ]
  const router = new VueRouter({
      mode:'history',
    routes // short for `routes: routes`
  })
  Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY, h:mm a');
});
Vue.filter('acOrDi', function (value) {
    if (value == 0) return 'disabled'
    return "active"
  });
//   Vue.filter('notAcOrDi', function (value) {
//     if (value == 0) return 'active'
//     return "disable"
//   });

window.Fire =new Vue();
// Vue.config.silent = true;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.config.silent = true;

const app = new Vue({
    el: '#app',
    router,
    data:{
        search:'',
        lg:'en',
    },
    methods:{
        searchit(){
            Fire.$emit('searching');
        },
        changeEn(){

            Fire.$emit('AfterCreated');
            this.$root.lg="en" ;
        },
        changeFr(){
            Fire.$emit('AfterCreated');
            this.$root.lg="fr";
        },
        lgReturn(){
            Fire.$emit('AfterCreated');
            return this.$root.lg;
        }

    },
});
