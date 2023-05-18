import { ref } from 'vue';
import { defineStore } from 'pinia';
import http from '../services/http';

export const useAuth = defineStore('auth', () => {
    const token = ref(localStorage.getItem('jwt'));
    const refreshToken = ref(localStorage.getItem('rjwt'));
    const fullName = ref(localStorage.getItem('fullName'));

    function login(tokenValue: string, refreshToken: string, fullName: string) {
        setToken(tokenValue);
        setRefreshToken(refreshToken);
        setUserFullName(fullName);
    }

    function setToken(tokenValue: string) {
        localStorage.setItem('jwt', tokenValue);
        token.value = tokenValue;
    }

    function isAuthenticated() {
        return token.value && fullName.value;
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
            await refreshTokenF();
            const tokenAuth = `Bearer ${token.value}`;
            const { data } = await http.get('auth', {
                headers: {
                    Authorization: tokenAuth
                }
            })  

            return true;
        } catch (error: any) {
            clear();
            return false;
        }
    }

    function clear() {
        localStorage.removeItem('jwt');
        localStorage.removeItem('rjwt');
        localStorage.removeItem('fullName');
        token.value = '';
        refreshToken.value = '';
        fullName.value = '';

    }

    async function refreshTokenF() {
        const tokenAuth = `Bearer ${refreshToken.value}`;
        const { data } = await http.get('refresh', {
            headers: {
                Authorization: tokenAuth
            }
        })
        if(data?.jwt) {
            setToken(data.jwt)
        }
    }

    return {
        token,
        refreshToken,
        fullName,
        setToken,
        setRefreshToken,
        setUserFullName,
        checkToken,
        login,
        isAuthenticated,
        clear
    }
})
