<template>
  <v-form @submit.prevent="submit">
    <v-container fluid>
      <h3>Reply to post</h3>
      <ckeditor :editor="editor" v-model="form.body"></ckeditor>
    </v-container>
    <v-btn type="submit">
      Post
    </v-btn>
  </v-form>
</template>

<script>
import Axios from 'axios'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue2';
export default {
  props: ['questionSlug'],
  components: {
    // Use the <ckeditor> component in this view.
    ckeditor: CKEditor.component
  },
  data(){
    return {
      form: {
        body: null,
      },
      editor: ClassicEditor,
    }
  },
  mounted(){

  },
  methods: {
    submit(){
      Axios.post(`/api/question/${this.questionSlug}/reply`, this.form)
        .then(res => {
          this.form.body = '';
          EventBus.$emit('newReply', res.data.data);
          window.scrollTo(0,0);
          window.location = `/question/${this.questionSlug}`;
          // console.log(res.data.data.body);
        })
        .catch(err => console.log(err))
    }
  }
}
</script>