<template>
  <div>
    <v-btn x-small color="red" dark @click="likeReply">
      Like {{ count }}
    </v-btn>
  </div>
</template>

<script>
import Axios from 'axios';
import User from '../../helpers/User'
export default {
  props: ['content'],
  data(){
    return {
      liked: this.content.liked,
      count: this.content.total_like
    }
  },
  methods: {
    likeReply(){
      if(User.loggedIn()){
        this.liked ? this.decr() : this.incr();
        this.liked = !this.liked;
      }
    },
    incr(){
      Axios.post('/api/like/reply/'+this.content.id)
        .then(res => this.count++)
        .catch(err => console.log(err.data))
    },
    decr(){
      Axios.delete('/api/like/reply/'+this.content.id)
        .then(res => this.count--)
        .catch(err => console.log(err.data))
    }
  },
  mounted(){
    // console.log(this.content);
  }
}
</script>