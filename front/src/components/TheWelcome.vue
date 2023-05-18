<script setup lang="ts">
import WelcomeItem from './WelcomeItem.vue'
import DocumentationIcon from './icons/IconDocumentation.vue'
import ToolingIcon from './icons/IconTooling.vue'
import EcosystemIcon from './icons/IconEcosystem.vue'
import CommunityIcon from './icons/IconCommunity.vue'
import SupportIcon from './icons/IconSupport.vue'
</script>

<template>
  <WelcomeItem>
    <template #icon>
      <DocumentationIcon />
    </template>
    <template #heading>Sobre o teste</template>

    Desafio Técnico PHP Desenvolva um programa para um mercado que permita:
    <ul>
      <li>Cadastro dos produtos</li>
      <li>Cadastro dos tipos de cada produto</li>
      <li>Cadastro dos valores percentuais de imposto dos tipos de produtos</li>
      <li>A tela de venda, onde serão informados os produtos e quantidades adquiridas</li>
      <li>O sistema deve apresentar o valor de cada item multiplicado pela quantidade adquirida e a
quantidade pago de imposto em cada item, um totalizador do valor da compra e um
totalizador do valor dos impostos</li>
      <li>A venda deverá ser salva</li>
    </ul>

    O sistema deverá ser desenvolvido utilizando
    <ul>
      <li>PHP 7.4 ou superior</li>
      <li>PostgreSQL ou MSSQL Server</li>
    </ul>
  </WelcomeItem>

  <WelcomeItem>
    <template #icon>
      <ToolingIcon />
    </template>
    <template #heading>Tecnologias que foram utilizadas</template>
    <ul>
      <li>PHP 8.1</li>
      <li>Vue JS 3 + Pinia</li>
      <li>PostgreSQL</li>
      <li>Token e Refresh Token com JWT</li>
    </ul>
  </WelcomeItem>
  <WelcomeItem>
    <template #icon>
      <ToolingIcon />
    </template>
    <template #heading>Tecnologias Opcionais</template>
    <ul>
      <li>Docker Compose configurado containers para: PHP-FPM, NGINX, DOCKER</li>
    </ul>
  </WelcomeItem>

</template>
