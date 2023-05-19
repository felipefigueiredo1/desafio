<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import { useAuth } from './stores/auth';
import { ref, onMounted } from 'vue';

const auth = useAuth()

</script>

<template>
  <header>
    <div class="wrapper">
      <nav>
        <RouterLink to="/login"  v-if="!auth.isAuthenticated()">Login</RouterLink>
        <RouterLink to="/" v-if="auth.isAuthenticated()">Home</RouterLink>
        <RouterLink to="/sales" v-if="auth.isAuthenticated()">Vendas</RouterLink>
        <RouterLink to="/products" v-if="auth.isAuthenticated()">Cadastrar Produtos</RouterLink>
        <RouterLink to="/product-types" v-if="auth.isAuthenticated()">Cadastrar Tipos de produtos</RouterLink>
        <RouterLink to="/product-type-tax-rates" v-if="auth.isAuthenticated()">Cadastrar Taxas</RouterLink>
        <RouterLink to="/about" >Sobre</RouterLink>
        <RouterLink to="/logoff" @click="auth.clear()" v-if="auth.isAuthenticated()">Logoff</RouterLink>
      </nav>
    </div>
  </header>
    <RouterView style="padding-left: 1rem"/>
</template>

<style scoped>
header {
  line-height: 1.5;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    font-size: 1rem;
    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
