import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../views/MainLayout.vue'
import BrowsePage from '../views/BrowsePage.vue'
import HomePage from '../views/HomePage.vue'
import UserLogin from '../views/UserLogin.vue'
import UserSignup from '../views/UserSignup.vue'
import RequestPasswordReset from '../views/RequestPasswordReset.vue'
import ResetPassword from '../views/ResetPassword.vue'
import ItemPage from '../views/ItemPage.vue'
import CreatePost from '../views/CreatePost.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    
    {
      path: '/',
      name: 'main-layout',
      component: MainLayout,
      children: [
        {
          path: '',
          name: 'home',
          component: HomePage
        },
        {
          path: '/browse',
          name: 'browse',
          component: BrowsePage
        },
        {
          path: '/create-post',
          name: 'create-post',
          component: CreatePost,
          props: true
        },
        {
          path: '/rental-properties/:slug',
          name: 'item-page',
          component: ItemPage,
          props: true
        },
        {
          path: '/user/login',
          name: 'user-login',
          component: UserLogin
        },
        {
          path: '/user/signup',
          name: 'user-signup',
          component: UserSignup
        },
        {
          path: '/user/request-password-reset',
          name: 'request-password-reset',
          component: RequestPasswordReset
        },
        {
          path: '/user/reset-password/:token/:email',
          name: 'reset-password',
          component: ResetPassword,
          props: true
        }
      ]
    },
    
  ],
})

export default router
