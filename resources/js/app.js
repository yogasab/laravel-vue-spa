require('./bootstrap');

window.Vue = require('vue');
import vuetify from './vuetify'
import router from './Router/router'
Vue.component('app-home', require('./components/AppHome.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router
});


