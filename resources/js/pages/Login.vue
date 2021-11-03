<template>
  <v-form @submit.prevent="login">
    <v-container>
      <v-col
        cols="12"
        sm="6"
        md="12"
        >
        <h3>Login</h3>
        <v-text-field label="Email" required type="email" v-model="form.email">
        </v-text-field>
        <v-text-field label="Password" required type="password" v-model="form.password">
        </v-text-field>
        <v-btn type="submit" color="green">
          Login
        </v-btn>
      </v-col>
    </v-container>
  </v-form>
</template>

<script>
export default {
  data(){
    return {
      form: {
        email: null,
        password: null
      }
    }
  },
  methods: {
    login(){
      axios.post('/api/auth/login', this.form)
      .then((res) => console.log(res.data.access_token))
      .catch((err) => console.log(err.response.data))
    }
  }
}
</script>