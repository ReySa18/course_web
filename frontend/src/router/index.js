import { createRouter, createWebHistory } from 'vue-router'

import Register from '../views/Register.vue'
import Login from '../views/Login.vue'
import Home from '../views/Home.vue'
import Kuiz from '../views/kuis.vue'
import Soal from '../views/Soal.vue'
import Admin from '../views/admin/admin.vue'
import UserManagement from '../views/admin/user.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/register', name: 'Register', component: Register },
  { path: '/login', name: 'Login', component: Login },
  { path: '/kuis', name: 'Kuiz', component: Kuiz },
  { path: '/soal', name: 'Soal', component: Soal },
  { path: '/admin',
    name: 'admin',
    component: Admin,
      beforeEnter: (to, from, next) => {
        const token = localStorage.getItem('auth_token')
        const role = localStorage.getItem('user_role')

        if (!token) {
          next('/login')
        } else if (role !== 'admin') {
          alert('Kamu bukan admin!')
          next('/login')
        } else {
          next()
        } 
      }
    },
  { path: '/usermanagement', name: 'Managemen User', component: UserManagement}
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
