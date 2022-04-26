import Vue from 'vue';
import Vuex from 'vuex';
//import axios from 'axios';

Vue.use(Vuex);

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

}

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
})