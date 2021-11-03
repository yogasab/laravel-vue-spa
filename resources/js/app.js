require('./bootstrap');

import vuetify from './vuetify'
import router from './Router/router'
import User from './Helpers/User'
import Vue from 'vue';

window.Vue = require('vue');
window.User = User;
window.EventBus = new Vue();
// console.log(User.loggedIn());

Vue.component('app-home', require('./components/AppHome.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router
});


