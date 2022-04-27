import Home from './components/Home.vue';
import Cadastrar from './components/auth/Cadastrar.vue'
import CarrinhoCompras from './components/shop/CarrinhoCompras.vue'
import Admin from './components/admin/Admin.vue'
import Entrar from './components/auth/Entrar.vue'
import Perfil from './components/auth/profile/Perfil.vue'

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
    },
    {
        path: '/Entrar',
        component: Entrar
    },
    {
        path: '/Perfil',
        component: Perfil
    }
]