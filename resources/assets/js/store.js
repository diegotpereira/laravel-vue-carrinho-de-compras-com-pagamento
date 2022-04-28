import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

const state = {
    token: localStorage.getItem('access_token') || null,
    admin: localStorage.getItem('ehAdmin') || null
}
const getters = {
    logado(state) {
        return state.token !== null
    },
    ehAdmin(state) {
        return state.admin !== null
    }
}
const mutations = {
    recuperarToken(state, token) {
        state.token = token
    },
    ehAdmin(state, ehAdmin) {
        state.admin = ehAdmin
    }
}
const actions = {
    recuperarToken(context, credentials) {
        return new Promise((resolve, reject) => {
            axios.post('/login', {
                    username: credentials.username,
                    password: credentials.password,
                })
                .then((response) => {
                    const token = response.data.access_token

                    localStorage.setItem('access_token', token)
                    context.commit('recuperarToken', token)

                    // verificar é função de administrador
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
                    axios.get('/ehAdmin')
                        .then((response) => {
                            const ehAdmin = response.data.role
                            localStorage.setItem('ehAdmin', ehAdmin)
                            context.commit('ehAdmin', ehAdmin)

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
    },
    AddNovoProduto(context, data) {
        return new Promise((resolve, reject) => {
            axios.post('/AddProduto', {
                    titulo: data.titulo,
                    descricao: data.descricao,
                    preco: data.preco,
                    imagePath: data.imagePath
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