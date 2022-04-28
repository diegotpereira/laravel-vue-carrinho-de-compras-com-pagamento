//require('./bootstrap');
window.Vue = require('vue')

import VueRouter from 'vue-router'
import App from './App.vue'
import { routes } from './routes'
import Vue from 'vue'
import store from './store'
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate)

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

//router.beforeEach((to, from, next) => {
//    if (to.matched.some(record => record.meta.requiresAuth)) {
//        // this route requires auth, check if logged in
//        // if not, redirect to login page.
//        if (!store.getters.loggedIn) {
//            next({
//                path: '/Entrar',
//            })
//        } else {
//            next()
//        }
//    } else if (to.matched.some(record => record.meta.requireVisitor)) {
//        // this route requires auth, check if logged in
//        // if not, redirect to login page.
//        if (store.getters.loggedIn) {
//            next({
//                path: '/Perfil',
//            })
//        } else {
//            next()
//        }
//    }
//    if (to.matched.some(record => record.meta.requiresAdmin)) {
//        // this route requires auth, check if logged in
//        // if not, redirect to login page.
//        if (!store.getters.ehAdmin) {
//            next({
//                path: ' ',
//            })
//        } else {
//            next()
//        }
//    } else {
//        next() // make sure to always call next()!
//    }
//})

Vue.component('app', require('./App.vue'))


const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App)
})