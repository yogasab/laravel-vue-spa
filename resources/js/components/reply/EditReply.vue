<template>
  <v-container fluid>
    <ckeditor :editor="editor" v-model="form.body" v-html="reply.reply"></ckeditor>
    <v-card-actions >
        <v-btn small outlined color="green" @click="update">
          Update
        </v-btn>
        <v-btn small outlined color="red" @click="cancelToggle">
          Cancel
        </v-btn>
      </v-card-actions>
  </v-container>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue2';
import Axios from 'axios';
export default {
  props: ['reply'],
  components: {
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
  methods: {
    cancelToggle(reply){
      EventBus.$emit('cancelEditing', reply);
    },
    update(){
      Axios.patch(`/api/question/${this.reply.question_slug}/reply/${this.reply.id}`, this.form)
      .then(res => {
        this.cancelToggle(this.reply)
        window.location = '/question/'+this.reply.question_slug;
      })
      .catch(err => console.log(err))
    }
  },
  mounted(){
    // console.log(this.reply);
  }
}
</script>