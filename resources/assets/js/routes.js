import Home from './components/Home.vue';
import Cadastrar from './components/auth/Cadastrar.vue'
import CarrinhoCompras from './components/shop/CarrinhoCompras.vue'
import Admin from './components/admin/Admin.vue'

export const routes = [

    {
        path: '/',
        component: Home
    },
    {
        path: '/Cadastrar',
        component: Cadastrar
    },
    {
        path: '/CarrinhoCompras',
        component: CarrinhoCompras
    },
    {
        path: '/Admin',
        component: Admin
    }
]