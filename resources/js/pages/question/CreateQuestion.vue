<template>
  <v-container>
    <h1>Ask Question</h1>
    <v-form @submit.prevent="create">
    <v-container>
      <v-col cols="12" sm="6" md="12">
        <v-text-field 
          label="Title" 
          required 
          type="text" 
          v-model="form.title">
        </v-text-field>
        <span class="red--text" v-if="errors.title">The title field is required</span>
        <v-select 
          :items="categories" 
          item-text="name" 
          item-value="id" 
          v-model="form.category_id" 
          label="Categories" 
          autocomplete>
        </v-select>
        <span class="red--text" v-if="errors.category_id">The categories field is required</span>
        <ckeditor :editor="editor" v-model="form.body"></ckeditor>
        <span class="red--text" v-if="errors.body">The body field is required</span>
        <v-spacer></v-spacer>
        <v-btn type="submit" color="green" class="mt-5">
          Create
        </v-btn>
      </v-col>
    </v-container>
  </v-form>
  </v-container>
</template>

<script>
import Axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue2';
export default {
  data(){
    return {
      form: {
        title: null,
        category_id: null,
        body: null
      },
      categories: [],
      errors: {},
      editor: ClassicEditor,
    }
  },
  components: {
    // Use the <ckeditor> component in this view.
    ckeditor: CKEditor.component
  },
  async created(){
    await Axios.get('/api/category')
    .then(res => this.categories = res.data.data)
    .catch(err => console.log(err.response.data))
  },
  methods: {
    create(){
      Axios.post('/api/question', this.form)
      .then(res => {
        this.form.title = null;
        this.form.category_id = null;
        this.form.body = null;
        this.$router.push(res.data.path)
      })
      .catch(err => {
        (this.errors = err.response.data.errors)
      })
    }
  }, 
  computed: {
    disabled(){
      return !(this.form.title&&this.form.category_id&&this.form.body)
    }
  }
}
</script>