<template>
    <div>
        <p>Faça o Login para poder acessar a aplicação.</p>

    <form @submit.prevent="login">
        <div class="mb-3">
            <input type="email" class="form-control" placeholder="Seu email" v-model="user.email">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" placeholder="Sua senha" v-model="user.password">
        </div>

        <button type="submit" class="btn btn-success">Login</button>
    </form>

    <ErrorContainer :error="errorResponse.message" v-if="errorResponse.message" />
</div>

</template>

<script setup>
import http from '@/services/http';
import { reactive, defineEmits } from 'vue';
import { useAuth } from '@/stores/auth.ts';
import router from '../router/index.ts';
import ErrorContainer from '../components/ErrorContainer.vue';

const auth = useAuth();

const user = reactive({
    email: 'felipe@email.com',
    password: '123456'
})

const errorResponse = reactive({message: ''});

async function login() {
    try {
        const { data } = await http.post('login',  user);
        auth.login(data.jwt, data.rjwt, data.user);
        router.push('/')
    } catch(error) {
        errorResponse.message = error.response.data.message;
    }
}

</script>

<style lang="scss" scoped>

</style>