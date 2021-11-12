<template>
  <v-menu transition="slide-y-transition" bottom>
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        class="purple"
        color="primary"
        dark
        v-bind="attrs"
        v-on="on"
      >
        Notifications {{ unreadsCount }}
      </v-btn>
    </template>
    <v-list>
      <v-list-item v-for="unread in unreads" :key="unread.id">
      <router-link :to="unread.path">
        <v-list-item-title v-html="unread.question" @click="readNotification(unread)">
          {{ unread.question }}
        </v-list-item-title>
      </router-link>
      </v-list-item>
      <v-list-item v-for="read in reads" :key="read.id">
        <v-list-item-title v-html="read.question">
          {{ read.question }}
        </v-list-item-title>
      </v-list-item>
    </v-list>
    <!-- <div v-else>
      <v-list>
        <v-list-item>
          <strong>You have no notification</strong>
        </v-list-item>
      </v-list>
    </div> -->
  </v-menu>
</template>

<script>
import Axios from 'axios'
import User from '../helpers/User'
import Exception from '../helpers/Exception'
export default {
  data(){
    return {
      items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
      ],
      reads: {},
      unreads: {},
      unreadsCount: 0,
    }
  },
  created(){
    if(User.loggedIn()){
      this.getNotifications()
    }
    window.Echo.private('App.User.' + User.id())
      .notification((notification) => {
        this.unreads.unshift(notification);
        this.unreadsCount++;
      });
  },
  methods: {
    getNotifications(){
      Axios.post('/api/notifications')
        .then(res => {
          console.log(res.data.read);
          this.reads = res.data.read;
          this.unreads = res.data.unread;
          this.unreadsCount = res.data.unread.length;
        })
        .catch(err => Exception.handle(err))
    },
    readNotification(notification){
      Axios.post('/api/readNotifications', {id: notification.id})
        .then(res => {
          this.unreads.splice(notification, 1);
          this.reads.push(notification);
          this.unreadsCount--;
        })
        .catch(err => {
          console.log(err)
        })
    }
  }
}
</script>