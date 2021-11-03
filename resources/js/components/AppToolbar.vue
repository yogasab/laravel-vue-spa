<template>
  <v-toolbar>
    <v-toolbar-title>Single Forum App</v-toolbar-title>
    <v-spacer></v-spacer>
    <div class="hidden-sm-and-down">
      <router-link to="/forum">
        <v-btn >Forum</v-btn>
      </router-link>
      <!-- 
      <v-btn elevation="2">Ask Question</v-btn>
      <v-btn elevation="2">Category</v-btn>
      <v-btn elevation="2">Register</v-btn> -->
      <router-link to="/login">
        <v-btn >Login</v-btn>
      </router-link>
    </div>
  </v-toolbar>
</template>

<script>
export default {
  
}
</script>