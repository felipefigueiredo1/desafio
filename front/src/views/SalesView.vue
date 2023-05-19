<template>
    <div>
        <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />
        
    </div> 
</template>

<script setup>
import http from '@/services/http';
import { reactive, onMounted } from 'vue';
import Table from '../components/Table.vue';
import {useAuth} from '../stores/auth.ts';
import WarningContainer from '../components/WarningContainer.vue';
import ErrorContainer from '../components/ErrorContainer.vue';

onMounted(() => {
    populateData();
})


</script>

<style lang="scss" scoped>

</style>