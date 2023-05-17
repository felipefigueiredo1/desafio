import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import LoginView from '../views/LoginView.vue';
import DashboardView from '../views/DashboardView.vue';
import CreateProductView from '../views/CreateProductView.vue';
import CreateCategoryView from '../views/CreateCategoryView.vue';
import { useAuth } from '@/stores/auth';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      meta: {
        auth: true
      }
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/createProduct',
      name: 'createProduct',
      component: CreateProductView,
      meta: {
        auth: true
      },
    },
    {
      path: '/createCategory',
      name: 'createCategory',
      component: CreateCategoryView,
      meta: {
        auth: true
      },
    }
  ]
});

router.beforeEach(async (to, from, next) => {
  if(to.meta?.auth) {
    const auth = useAuth();
    if(auth.token && auth.fullName) {
      const isAuthenticated =  await auth.checkToken();

      if(isAuthenticated) {
        next();
      }
    } else {
      next({name: 'login'})  
    }
    console.log(to.name);
  } else {
    next()
  }
})

export default router
