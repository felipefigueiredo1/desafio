import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import LoginView from '../views/LoginView.vue';
import ProductsView from '../views/ProductsView.vue';
import ProductTypesView from '../views/ProductTypesView.vue';
import ProductTypeTaxRatesView from '../views/ProductTypeTaxRatesView.vue';
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
      path: '/logoff',
      name: 'logoff',
      redirect: to => {
        // the function receives the target route as the argument
        // we return a redirect path/location here.
        return { path: '/login'}
      },
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/products',
      name: 'products',
      component: ProductsView,
      meta: {
        auth: true
      },
    },
    {
      path: '/product-types',
      name: 'product-types',
      component: ProductTypesView,
      meta: {
        auth: true
      },
    },
    {
      path: '/product-type-tax-rates',
      name: 'product-type-tax-rates',
      component: ProductTypeTaxRatesView,
      meta: {
        auth: true
      }
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
