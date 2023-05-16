import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import LoginView from '../views/LoginView.vue';
import DashboardView from '../views/DashboardView.vue';
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
