<template>
    <div v-if="products.itens">
        <Table :columns="['ID', 'Name', 'Product Type ID', 'Created']" :rows="products.itens"/>
    </div>
</template>

<script setup>
import http from '@/services/http';
import { reactive, onMounted } from 'vue';
import Table from '../components/Table.vue';

const products = reactive({itens: []})


onMounted(() => {
    populateProducts();
})

async function populateProducts() {
    const { data } = await http.get('products');
    
    products.itens = data.products;
}

</script>

<style lang="scss" scoped>

</style>