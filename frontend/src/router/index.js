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
import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'

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
          props: (route)=> ({
            street: route.query.street,
            locality: route.query.locality,
            city: route.query.city,
            state: route.query.state,
            pincode: route.query.pincode,
            country: route.query.country,

          }),
          component: BrowsePage
        },
        {
          path: '/create-post',
          name: 'create-post',
          component: CreatePost,
          props: true,
          meta: {requiresAuth: true}
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
          component: UserLogin,
          meta: {requiresLogout: true}
        },
        {
          path: '/user/signup',
          name: 'user-signup',
          component: UserSignup,
          meta: {requiresLogout: true}
        },
        {
          path: '/user/request-password-reset',
          name: 'request-password-reset',
          component: RequestPasswordReset,
          meta: {requiresLogout: true}
        },
        {
          path: '/user/reset-password/:token/:email',
          name: 'reset-password',
          component: ResetPassword,
          props: true,
          meta: {requiresLogout: true}
        }
      ]
    },
    
  ],
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth', // Smooth scroll
      };
    }
    return savedPosition || { top: 0 };
  },
})

router.beforeEach(async (to, from, next)=>{
  const {checkToken} = useAuthStore();

  if(to.meta.requiresAuth  ){

    const check = await checkToken(true)
    if(!check){
      
      return next('/user/login')
    }

    next()
   
  }

  if(to.meta.requiresLogout){
    const check =await checkToken(true)
    if(check){
      return next('/')
    }

    next()
  }

  next()
  
})

export default router
