<template>
    <div>
        <h2>Login</h2>

    <form @submit.prevent="login">
        <input type="text" placeholder="Seu email" v-model="user.email">
        <input type="password" placeholder="Sua senha" v-model="user.password">
        <button type="submit">Login</button>
    </form>
</div>

</template>

<script setup>
import http from '@/services/http';
import { reactive, defineEmits } from 'vue';
import { useAuth } from '@/stores/auth.ts';

const emit = defineEmits(['loginUser'])

const auth = useAuth();

const user = reactive({
    email: 'felipe@email.com',
    password: '123456'
})

async function login() {
    try {
        const { data } = await http.post('login',  user);
        auth.login(data.jwt, data.rjwt, data.user);
    } catch(error) {
        console.log(error);
    }
}

</script>

<style lang="scss" scoped>

</style>