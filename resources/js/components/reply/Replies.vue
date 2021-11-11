<template>
  <v-card>
    <v-toolbar dark>
      <v-toolbar-title>Replies</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-list two-line>
      <v-list-item-group>
        <reply 
          v-for="(reply, index) in question.replies" 
          :key="reply.id" 
          :index=index 
          :data="reply">
        </reply>
      </v-list-item-group>
    </v-list>
  </v-card>
</template>

<script>
import Axios from 'axios';
import Reply from './Reply.vue'
import User from '../../helpers/User';
export default {
  props: ['question'],
  components: { Reply },
  created(){
    this.listen();
  },
  methods: {
    listen(){
      EventBus.$on('newReply',(reply) => {
        this.question.replies.unshift(reply);
        window.scrollTo(0,0);
      })
      EventBus.$on('deleteReply', (index) => {
        Axios.delete(`/api/question/${this.question.slug}/reply/${this.question.replies[index].id}`)
        .then(res => {
          // window.location = `/question/${this.question.slug}`;
          this.question.replies.splice(index, 1);
          window.scrollTo(0,0);
        })
      })

      window.Echo.private('App.User.' + User.id())
        .notification((notification) => {
          this.question.replies.unshift(notification.reply)
        });

      window.Echo.channel('deleteReplyChannel')
        .listen('DeleteReplyEvent', (e) => {
          for(let index = 0; index < this.question.replies.length; index++){
            if(this.question.replies[index].id == e.id){
              this.question.replies.splice(index, 1)
            }
          }
        })
    }
  }
}
</script>