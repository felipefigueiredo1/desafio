<template>
    <div>
        <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />

        <div v-if="productTypes.itens.length < 1">
            <WarningContainer warning="Cadastre ao menos um tipo de produto" />
        </div>
        <div v-if="productTypeTaxRates.itens.length > 0">
            <Table :columns="['ID', 'Taxa', 'Tipo de Produto', 'Criado em']" :rows="productTypeTaxRates.itens"/>
        </div>
        <form @submit.prevent="save">
            <div class="mb-3">
                <label for="name" class="form-label">Taxa</label>
                <input type="number" class="form-control" id="name" v-model="tax.tax_rate">
                <div id="emailHelp" class="form-text">O valor percentual da taxa de imposto para o tipo de produto.</div>
            </div>
            <div class="mb-3">
                <select v-model="tax.product_type_id" class="form-select">
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

onMounted(async () => {
    await auth.refreshTokenF();
    populateData();
})

const productTypes = reactive({itens: []})
const productTypeTaxRates = reactive({itens: []})
const auth = useAuth();
const tax = reactive({tax_rate: '', product_type_id: ''})
const errorResponse = reactive({message: ''});

async function populateData() {
    productTypes.itens = await getProductTypes();
    productTypeTaxRates.itens = await getProductTypeTaxRates();
    if(productTypeTaxRates.itens.length > 0) {
        productTypeTaxRates.itens = productTypeTaxRates.itens.map(item => {
            const productType = productTypes.itens.find(type => type.id === item.product_type_id);
            const name = productType ? productType.name : '';
            const tax = item.tax_rate + "%";
            return {...item, product_type_id: name, tax_rate: tax};
        });
    }
}

async function getProductTypes() {
    const { data } = await http.get('product-types', {
        headers: {
            Authorization: `Bearer ${auth.token}`
        }
    });
    console.log(data);
    return data.productTypes;
}

async function getProductTypeTaxRates() {
    const { data } = await http.get('product-type-tax-rates', {
        headers: {
            Authorization: `Bearer ${auth.token}`
        }
    });
    
    return data.productTypeTaxRates;
}

async function save() {
    try {
        await auth.refreshTokenF();
        await http.post('product-type-tax-rates',  tax, {
            headers: {
                Authorization: `Bearer ${auth.token}`
            }
        }); 
        populateData();
    } catch(error) {
        errorResponse.message = error.response.data.message;
    }
}


</script>

<style lang="scss" scoped>

</style>