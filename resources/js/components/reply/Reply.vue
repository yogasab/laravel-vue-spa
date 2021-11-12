<template>
  <div>
    <edit-reply v-if="editing" :reply="data"></edit-reply>
    <div v-else>
      <v-list-item :key="data.id">
        <v-list-item-content>
          <v-list-item-title v-text="data.user"></v-list-item-title>
          <v-list-item-subtitle
          ></v-list-item-subtitle>
          <v-list-item-subtitle>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis facilis sit quaerat molestiae at temporibus commodi doloribus nostrum odit fugit eos iure, repellat, omnis consequatur inventore eius expedita! Dignissimos, magnam.
          </v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
          <v-list-item-action-text>{{data.created_at}}</v-list-item-action-text>
        </v-list-item-action>
        <v-list-item-action>
          <like :content="data"></like>
        </v-list-item-action>
      </v-list-item>
      <v-divider></v-divider>

      <v-card-actions v-if="own">
        <v-btn small outlined color="orange" @click="toggleEdit">
          Edit
        </v-btn>
        <v-btn small outlined color="red" @click="destroy">
          Delete
        </v-btn>
      </v-card-actions>
    </div>
  </div>
</template>
<script>
import User from '../../helpers/User'
import Like from '../likes/Like.vue'
import EditReply from './EditReply.vue'
export default {
  components: { EditReply, Like },
  props: ['data', 'index'],
  data(){
    return {
      editing: false,
    }
  },
  computed: {
    own(){
      return User.owned(this.data.user_id)
    }
  },
  created(){
    this.listen();
  },
  methods: {
    destroy(){
      EventBus.$emit('createReply', this.form)
      EventBus.$emit('deleteReply', this.index);
    },
    toggleEdit(){
      this.editing = !this.editing;
    },
    listen(){
      EventBus.$on('cancelEditing', (reply) => {
        this.editing = false;
      })
    }
  },
}
</script>