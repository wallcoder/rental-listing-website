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
import UserPage from '@/views/UserPage.vue'
import PostBoost from '@/views/PostBoost.vue'
import Checkout from '@/views/Checkout.vue'
import Profile from '@/components/UserPage/Profile.vue'
import Saved from '@/components/UserPage/Saved.vue'
import Posts from '@/components/UserPage/Posts.vue'
import KYC from '@/components/UserPage/KYC.vue'
import Transactions from '@/components/UserPage/Transactions.vue'
import Subscription from '@/components/UserPage/Subscription.vue'
import NotFound from '@/views/NotFound.vue'
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
          meta: {
            title: 'Home'
          },
          component: HomePage
        },
        {
          path: '/browse',
          name: 'browse',
          meta: {
            title: 'Browse'
          },
          props: (route) => ({
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
          meta: {
            title: 'Create Post',
            requiresAuth: true
          }
        },
        {
          path: '/boost',
          name: 'boost',
          component: PostBoost,
          props: true,
          meta: {
            title: 'Boost',
            requiresAuth: true
          }
        },
        {
          path: '/rental-properties/:slug',
          name: 'item-page',
          component: ItemPage,
          props: true,
          meta: {
            title: 'Listing'
          },
        },
        {
          path: '/user/login',
          name: 'user-login',
          component: UserLogin,
          meta: { title: 'Login', requiresLogout: true }
        },
        {
          path: '/user/signup',
          name: 'user-signup',
          component: UserSignup,
          meta: { title: 'Sign Up', requiresLogout: true }
        },
        {
          path: '/user/request-password-reset',
          name: 'request-password-reset',
          component: RequestPasswordReset,
          meta: { requiresLogout: true }
        },
        {
          path: '/user/reset-password/:token/:email',
          name: 'reset-password',
          component: ResetPassword,
          props: true,
          meta: { requiresLogout: true }
        },

        {
          path: '/user',
          name: 'user-page',
          component: UserPage,

          meta: { title: 'User Page', requiresAuth: true },
          children: [
            {
              path: '',
              name: 'user-profile',
              component: Profile
            },
            {
              path: 'posts',
              name: 'user-posts',
              component: Posts
            },
            {
              path: 'saved',
              name: 'user-saved',
              component: Saved
            },
            {
              path: 'transactions',
              name: 'user-transactions',
              component: Transactions
            },
            {
              path: 'kyc',
              name: 'kyc',
              component: KYC
            },
            // {
            //   path: 'subscriptions',
            //   name: 'user-subscriptions',
            //   component: Subscription
            // },

          ]
        },
        {
          path: 'checkout',
          name: 'checkout',
          component: Checkout
        },
        
        {
          path: '/:pathMatch(.*)*',
          component: NotFound,
          meta: { title: 'Page Not Found' }
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

router.beforeEach(async (to, from) => {
  const { checkToken } = useAuthStore();

  if (to.meta.requiresAuth) {
    const check = await checkToken(true);
    if (!check) {
      return '/user/login'; // redirect
    }
    return true; // allow
  }

  if (to.meta.requiresLogout) {
    const check = await checkToken(true);
    if (check) {
      return '/'; // redirect to home
    }
    return true; // allow
  }

  return true; // allow by default
});

router.afterEach((to) => {
  const defaultTitle = 'inlist';
  document.title = `inlist | ${to.meta.title}` || defaultTitle;
});


export default router
