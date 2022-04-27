import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
//import { URL_BASE } from '../../assets/js/project/configs/configs'


Vue.use(Vuex);

//axios.defaults.baseURL = 'http://localhost:8000/api'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
//const RESOURCE = '/registrar';

const state = {
    token: localStorage.getItem('access_token') || null
}
const getters = {
    logado(state) {
        return state.token !== null
    }
}
const mutations = {
    recuperarToken(state, token) {
        state.token = token
    }
}
const actions = {
    recuperarToken(context, credentials) {
        return new Promise((resolve, reject) => {
            axios.post('/entrar', {
                    username: credentials.username,
                    password: credentials.password
                })
                .then((response) => {
                    const token = response.data.access_token

                    localStorage.setIte('access_token', token)
                    context.commit('recuperarToken', token)

                    // verificar é função de administrador
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
                    axios.get('/ehAdmin')
                        .then((response) => {
                            const ehAdmin = response.data.role
                            localStorage.setItem('ehAdmin', ehAdmin)

                            // fim da função de verificação
                            resolve(response)
                        })
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    registrar(context, data) {
        return new Promise((resolve, reject) => {
            axios.post('/registrar', {
                    name: data.name,
                    email: data.email,
                    password: data.password
                })
                .then((response) => {
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })
        })
    }
}

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
})