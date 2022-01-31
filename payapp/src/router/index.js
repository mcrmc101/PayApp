import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Activate from '../views/Activate.vue'
import Admin from '../views/Admin.vue'
import Payment from '../views/Payment.vue'
import PaymentSuccess from '../views/PaymentSuccess.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },

  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/activate',
    name: 'Activate',
    component: Activate
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin
  },
  {
    path: '/payment',
    name: 'Payment',
    component: Payment,
    params: true
  },
  {
    path: '/paymentsuccess',
    name: 'PaymentSuccess',
    component: PaymentSuccess,
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
