<template>
  <v-toolbar color="navy" dark>
    <router-link to="/" style="text-decoration: none; color: #FFF;">
      <v-toolbar-title class="headline">
        Single Page Forum
      </v-toolbar-title>
    </router-link>
    <v-spacer></v-spacer>
    <div class="hidden-sm-and-down">
      <app-notifications class="mr-3"></app-notifications>
      <router-link v-for="item in items" :to="item.to" :key="item.title" style="text-decoration: none;">
        <v-btn v-if="item.show" class="mr-4">{{ item.title }}</v-btn>
      </router-link>
    </div>
  </v-toolbar>
</template>

<script>
import User from '../helpers/User'
import AppNotifications from './AppNotifications.vue'
export default {
  components: { AppNotifications },
  data(){
    return {
      items: [
        {title: 'Forum', to: '/forum', show: true},
        {title: 'Login', to: '/login', show: !User.loggedIn()},
        {title: 'Register', to: '/register', show: !User.loggedIn()},
        {title: 'Logout', to: '/logout', show: User.loggedIn()},
        {title: 'Ask Question', to: '/ask', show: User.loggedIn()},
        {title: 'Category', to: '/category', show: User.admin()},
      ]
    }
  },
  created(){
    EventBus.$on('logout', () => {
      User.loggedOut();
    })
  }
}
</script>