<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs8>
        <question style="margin-bottom: 10px;"
          v-for="question in questions" 
          :key="question.slug"
          :data=question
        >
        </question>
        <div class="text-center">
          <v-pagination
            v-model="meta.current_page"
            :length="meta.last_page"
            @input="paginate"
          ></v-pagination>
        </div>
      </v-flex>
      <v-flex xs4>
        <app-sidebar></app-sidebar>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Axios from 'axios'
import question from '../../components/question/Question.vue'
import AppSidebar from '../../components/AppSidebar.vue'
export default {
  components: {
    question,
    AppSidebar
  },
  data(){
    return {
      questions: {},
      page: 2,
      meta: {}
    }
  },
  created(){
    this.fetchQuestion()
  },
  methods: {
    fetchQuestion(page){
      let url = page ? `/api/question?page=${page}` : '/api/question'
      Axios.get(url)
      .then(res => {
        this.questions = res.data.data
        this.meta = res.data.meta
      })
      .catch(err => console.log())
    },
    paginate(page){
      this.fetchQuestion(page)
    }
  }
}
</script>