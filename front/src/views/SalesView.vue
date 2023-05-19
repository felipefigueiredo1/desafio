<template>
    <div>
        <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />
        <Table :columns="['ID', 'Quantidade', 'Nome do Produto', 'Criado em', 'Preço', 'Tipo do produto']" :rows="sales.itens"/>
    </div> 
</template>

<script setup>
import http from '@/services/http';
import { reactive, onMounted } from 'vue';
import Table from '../components/Table.vue';
import {useAuth} from '../stores/auth.ts';
import WarningContainer from '../components/WarningContainer.vue';
import ErrorContainer from '../components/ErrorContainer.vue';

const products = reactive({itens: []})
const productTypes = reactive({itens: []})
const auth = useAuth();
const product = reactive({name: '', product_type_id: ''})
const errorResponse = reactive({message: ''});
const sales = reactive({itens: []})

onMounted(async () => {
    await auth.refreshTokenF();
    populateData();
})

async function populateData() {
    let data = await getSales();
    products.itens = data.products;
    sales.itens = data.sales;
    productTypes.itens = await getProductTypes();
    if(products.itens.length > 0) {
        products.itens = products.itens.map(item => {
        const productType = productTypes.itens.find(type => type.id === item.product_type_id);
        const name = productType ? productType.name : '';
        return {...item, product_type_id: name};
    });

    sales.itens = sales.itens.map(item => {
        const product = products.itens.find(product => product.id === item.product_id);

        return {...item, price: "R$ " + product.price * item.quantity, product_id: product.name, product_type: product.product_type_id}
    })
    }
}

async function getProducts() {
    const { data } = await http.get('products', {
        headers: {
            Authorization: `Bearer ${auth.token}`
        }
    });
    
    return data.products;
}

async function getSales() {
    const { data } = await http.get('sales', {
        headers: {
            Authorization: `Bearer ${auth.token}`
        }
    });

    return data;
}

async function getProductTypes() {
    const { data } = await http.get('product-types', {
        headers: {
            Authorization: `Bearer ${auth.token}`
        }
    });
    return data.productTypes;
}


</script>

<style lang="scss" scoped>

</style>