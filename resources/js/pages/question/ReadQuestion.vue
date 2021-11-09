<template>
  <div v-if="question">
    <edit-question v-if="editing" :data=question></edit-question>
    <show-question v-else :data="question"></show-question>
    <v-container fluid>
      <replies :question=question></replies>
      <create-reply :questionSlug="question.slug"></create-reply>
    </v-container>
  </div>
</template>

<script>
import Axios from 'axios'
import ShowQuestion from '../../components/question/ShowQuestion.vue';
import EditQuestion from '../../components/question/EditQuestion.vue';
import Replies from '../../components/reply/Replies.vue';
import CreateReply from '../../components/reply/CreateReply.vue';
export default {
  components: { ShowQuestion, EditQuestion, Replies, CreateReply },
  data(){
    return {
      question: {},
      editing: false,
    }
  },
  created(){
    this.listen();
    this.getQuestion();
  },
  methods: {
    listen(){
      EventBus.$on('editQuestion', () => {
        this.editing = true;
      })
      EventBus.$on('cancelEdit', () => {
        this.editing = false;
      })
    },
    getQuestion(){
      Axios.get(`/api/question/${this.$route.params.slug}`)
      .then(res => this.question = res.data.data)
      .catch(err => console.log(err))
    }
  }
}
</script>


