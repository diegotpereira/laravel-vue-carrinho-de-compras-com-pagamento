require('./bootstrap');
window.Vue = require('vue')

import VueRouter from 'vue-router'
import App from './App.vue'
import { routes } from './routes'
import Vue from 'vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

Vue.component('app', require('./App.vue'))


const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
})