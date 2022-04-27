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

}
const actions = {
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