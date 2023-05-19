<script setup lang="ts">
import TheWelcome from '../components/TheWelcome.vue'

</script>

<template>
  <div>
    <TheWelcome />
    <p>É possivel executar o back-end a partir do docker-compose que deixei configurado</p>
    <p>Docker compose: 
      <ul>
        <li>Crie a network: `docker network create my-app-network` </li>
      <li>
        Execute o comando a seguir em backend: `docker compose up -d`
      </li>
      </ul>
    </p>
    <p>PHP Server: execute o comando a seguir em backend/public:
      <ul>
        <li>php -S localhost:PORTA</li>
      </ul>
    </p>
  </div>
</template>

<style>
</style>
