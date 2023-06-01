<template>
  <div>
    <h3>Produtos: </h3>
      <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />
      <div v-for="(type, index) in productTypes.itens">
        <h4>{{ type.name }}</h4>
        <div class="d-flex gap-2">
          <template v-for="(item, index) in products.itens"  class="d-flex">
            <div v-if="item.product_type_id == type.id" class="card bg-dark" style="cursor: pointer" @click="selectProduct(item)">
              <div class="card-body">
                <span>{{ item.name }}, {{ item.priceF }}</span>
              </div>
            </div>
          </template>
        </div>
      </div>
      

      <div v-if="Object.keys(selectedProduct).length !== 0" class="mt-4 form-group">
        <label>Adicione a quantidade: </label>
        {{ selectedProduct.name }}
        <input type="number" v-model="quantity" min="1" max="10" placeholder="Quantidade" class="form-control">
        <button @click="addProduct()" class="btn btn-success mt-2">Adicionar</button>
      </div>

      <div v-if="selectedProducts.itens.length > 0">
        <h5>Produtos Selecionados:</h5>
        <ul>
          <li v-for="(  item, index) in selectedProducts.itens" :key="item.id">
            <div class="card bg-dark" style="cursor: pointer; margin-top: 10px; margin-bottom:10px; width:50%">
              <div class="card-body">
                <span style="margin-right:8px">{{ item.name }}, R$ {{ item.price * item.qty }}, imposto {{  item.priceTax }}% </span> <button @click="deleteProduct(index)" class="btn btn-danger" style="margin-right: 5px;">Remover</button>
              </div>
            </div>
          </li>
        </ul>
        <button @click="save" class="btn btn-success">Salvar venda</button>
      </div>
  </div> 
</template>

<script setup>
import http from '@/services/http';
import { reactive, onMounted, ref } from 'vue';
import Table from '../components/Table.vue';
import {useAuth} from '../stores/auth.ts';
import WarningContainer from '../components/WarningContainer.vue';
import ErrorContainer from '../components/ErrorContainer.vue';
import router from '../router/index.ts';



onMounted(async () => {
  await auth.refreshTokenF();
  populateData();
})

const products = reactive({itens: []})
const productTypes = reactive({itens: []})
const auth = useAuth();
const product = reactive({name: '', product_type_id: ''})
const errorResponse = reactive({message: ''});
let selectedProduct = ref({});
let quantity = ref(1);
const selectedProducts = reactive({itens: []})
const productTypeTaxRates = reactive({itens: []})

async function save() {
  try {
      await auth.refreshTokenF();
      await http.post('sales',  selectedProducts, {
          headers: {
              Authorization: `Bearer ${auth.token}`
          }
      });
      router.push('/sales')
  } catch(error) {
      errorResponse.message = error.response.data.message;
  }
}

function selectProduct(product) {
  selectedProduct.value = product;
}

function addProduct() {
  if(Object.keys(selectedProduct).length > 0 && quantity.value > 0) {

    selectedProducts.itens.push({
      name: selectedProduct.value.name,
      id: selectedProduct.value.id,
      qty: quantity.value,
      price: selectedProduct.value.price,
      priceTax: selectedProduct.value.priceTax
    })

    selectedProduct.value = {};
    quantity.value = 1;
  }
}

async function populateData() {
  products.itens = await getProducts();
  productTypes.itens = await getProductTypes();
  productTypeTaxRates.itens = await getProductsTypeTaxRates();
  if(products.itens.length > 0) {
      products.itens = products.itens.map(item => {
      const productType = productTypes.itens.find(type => type.id === item.product_type_id);
      const name = productType ? productType.name : '';
      const priceF = "R$ "+ item.price;
      const productTypeTaxRate = productTypeTaxRates.itens.find(rate => rate.product_type_id === item.product_type_id);
      const taxRate = productTypeTaxRate ? productTypeTaxRate.tax_rate : 0; 
      const priceWithTax = taxRate;
      return {...item, product_type_name: name, priceF: priceF, priceTax: priceWithTax};
  });
  }
}

async function getProducts() {
  const { data } = await http.get('products', {
      headers: {
          Authorization: `Bearer ${auth.token}`
      }
  });
  console.log(data);
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

async function getProductsTypeTaxRates() {
  const { data } = await http.get('product-type-tax-rates', {
      headers: {
          Authorization: `Bearer ${auth.token}`
      }
  });
  return data.productTypeTaxRates;
}

function deleteProduct(index) {
  selectedProducts.itens.splice(index, 1);
}

</script>

<style scoped>
span {
 color: hsla(160, 100%, 37%, 1);
}
</style>