require('./bootstrap');

import vuetify from './vuetify'
import router from './Router/router'
import User from './Helpers/User'

window.Vue = require('vue');
window.User = User;
console.log(User.id());

Vue.component('app-home', require('./components/AppHome.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router
});


