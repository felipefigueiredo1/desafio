<template>
    <div>
        <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />

        <div v-if="productTypes.itens.length < 1">
            <WarningContainer warning="Cadastre ao menos um tipo de produto" />
        </div>
        <div v-if="products.itens.length > 0">
            <Table :columns="['ID', 'Nome', 'Tipo de Produto', 'Preço', 'Criado em']" :rows="products.itens"/>
        </div>

        <form @submit.prevent="save">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" v-model="product.name">
                <div id="emailHelp" class="form-text">O nome do do produto.</div>
            </div>
            <div class="mb-3">
                <select v-model="product.product_type_id" class="form-select">
                    <option v-for="(item, index) in productTypes.itens" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
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

onMounted(async () => {
    await auth.refreshTokenF();
    populateData();
})

async function save() {
    try {
        await auth.refreshTokenF();
        await http.post('products',  product, {
            headers: {
                Authorization: `Bearer ${auth.token}`
            }
        });
        populateData();
    } catch(error) {
        console.log(error);
        errorResponse.message = error.response.data.message;
    }
}

async function populateData() {
    products.itens = await getProducts();
    productTypes.itens = await getProductTypes();

    if(products.itens.length > 0) {
        products.itens = products.itens.map(item => {
        const productType = productTypes.itens.find(type => type.id === item.product_type_id);
        const name = productType ? productType.name : '';
        const priceF = "R$ "+ item.price;
        return {...item, product_type_id: name, price: priceF};
    });
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