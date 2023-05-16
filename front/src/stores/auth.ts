import { ref } from 'vue';
import { defineStore } from 'pinia';
import http from '../services/http';

export const useAuth = defineStore('auth', () => {
    const token = ref(localStorage.getItem('jwt'));
    const refreshToken = ref(localStorage.getItem('rjwt'));
    const fullName = ref(localStorage.getItem('fullName'));

    function setToken(tokenValue: string) {
        localStorage.setItem('jwt', tokenValue);
        token.value = tokenValue;
    }

    function setRefreshToken(refreshTokenValue: string) {
        localStorage.setItem('rjwt', refreshTokenValue);
        refreshToken.value = refreshTokenValue;
    }

    function setUserFullName(fullNameValue: string) {
        localStorage.setItem('fullName', fullNameValue);
        fullName.value = fullNameValue;
    }

    async function checkToken() {
        try {
            await refreshTokenF()
            const tokenAuth = `Bearer ${token.value}`;
            const { data } = await http.get('auth', {
                headers: {
                    Authorization: tokenAuth
                }
            })

            return data;
        } catch (error: any) {
            console.log(error);
            return false;
        }
    }

    async function refreshTokenF() {
        const tokenAuth = `Bearer ${refreshToken.value}`;
        const { data } = await http.get('refresh', {
            headers: {
                Authorization: tokenAuth
            }
        })
        
        setToken(data.jwt)
    }

    return {
        token,
        refreshToken,
        fullName,
        setToken,
        setRefreshToken,
        setUserFullName,
        checkToken
    }
})
