import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Forum from '../pages/Forum.vue'
import Logout from '../pages/Logout.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login', component: Login
  },
  {
    path: '/register', component: Register
  },
  {
    path: '/forum', component: Forum, name: 'forum'
  },
  {
    path: '/logout', component: Logout, name: 'logout'
  }
]

const router = new VueRouter({
  routes,
  mode: 'history',
})

export default router