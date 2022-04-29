import axios from 'axios';
import { reject } from 'lodash';
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

const state = {
    token: localStorage.getItem('access_token') || null,
    admin: localStorage.getItem('ehAdmin') || null,
    ProdutoDado: null,
    carrinhoStore: JSON.parse(localStorage.getItem('carrinhoStore')) || [],
    precoTotal: localStorage.getItem('precoTotal') || 0,
    usuarioDado: null
}
const getters = {
    precoTotal(state) {
        return state.precoTotal
    },
    carrinhoNumero(state) {
        return state.carrinhoStore
    },
    logado(state) {
        return state.token !== null
    },
    ehAdmin(state) {
        return state.admin !== null
    },
    ProdutoDado(state) {
        return state.ProdutoDado
    },
    usuarioDado(state) {
        return state.usuarioDado
    }
}
const mutations = {
    recuperarToken(state, token) {
        state.token = token
    },
    ehAdmin(state, ehAdmin) {
        state.admin = ehAdmin
    },
    usuarioDado(state, usuarioDado) {
        state.usuarioDado = usuarioDado
    },
    ProdutoDado(state, ProdutoDado) {
        state.ProdutoDado = ProdutoDado
    },
    AddNoCarrinho(state, data) {
        const itensPreco = state.precoTotal
        const precoTotal = state.precoTotal
        const novoArray = state.carrinhoStore
        const item = data
        const id = data.id
        const quantidade = data.quantidade
        const preco = data.preco

        const ultimoPreco = Number(preco) * Number(quantidade) + Number(itensPreco)
        state.precoTotal = ultimoPreco

        localStorage.setItem("precoTotal", ultimoPreco)

        // O método find() retorna o valor do primeiro elemento 
        // do array que satisfizer a função de teste provida. 
        // Caso contrario, undefined é retornado.
        const gravar = novoArray.find(value => value.id === id)

        if (gravar) {
            gravar.quantidade++
                state.carrinhoStore = novoArray
            localStorage.setItem("carrinhoStore", JSON.stringify(novoArray))
        }
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
    },
    ProdutoDado(context, ProdutoDado) {
        console.log(ProdutoDado);
        if (context.getters.logado) {

            return new Promise((resolve, reject) => {
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
                    axios.get('/produto')
                        .then((response) => {
                            context.commit('ProdutoDado', response.data.produtos)
                            resolve(response)
                        })
                })
                .catch(error => {
                    reject(error)
                })
        }
    },
    usuarioDado(context, usuarioDado) {
        if (context.getters.logado) {

            return new Promise((resolve, reject) => {
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
                    axios.get('/user')
                        .then((response) => {
                            context.commit('usuarioDado', response.data)
                            resolve(response)
                        })
                })
                .catch(error => {
                    reject(error)
                })
        }
    },
    AddNoCarrinho(context, data) {
        const id = data
        context.commit('AddNoCarrinho', {
            id: data.id,
            preco: data.preco,
            quantidade: data.quantidade
        })
    }
}

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
})