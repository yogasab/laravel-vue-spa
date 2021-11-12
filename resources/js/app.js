require('./bootstrap');

import Vue from 'vue';
import vuetify from './vuetify'
import router from './router/router'
import User from './Helpers/User'
import Exception from './Helpers/Exception'

window.Vue = require('vue');
window.User = User;
window.Exception = Exception;
window.EventBus = new Vue();
// console.log(User.loggedIn());

Vue.component('app-home', require('./components/AppHome.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router
});


