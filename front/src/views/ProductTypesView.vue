<template>
    <div>
        <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />

        <div v-if="productTypes.itens.length > 0">
            <Table :columns="['ID', 'Nome', 'Criado em']" :rows="productTypes.itens"/>
        </div>
        <form @submit.prevent="save">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" v-model="productType.name">
                <div id="emailHelp" class="form-text">O nome do tipo do produto.</div>
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

const auth = useAuth();

const productTypes = reactive({itens: []})

onMounted(() => {
    populateData();
    console.log(productTypes);
})

const productType = reactive({name: ''})

const errorResponse = reactive({message: ''});

async function save() {
    try {
        await http.post('product-types',  productType, {
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
    productTypes.itens = await getProductTypes();
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

</script>

<style lang="scss" scoped>

</style>