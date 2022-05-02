import Home from './components/Home.vue';
import Cadastrar from './components/auth/Cadastrar.vue'
import CarrinhoCompras from './components/shop/CarrinhoCompras.vue'
import Admin from './components/admin/Admin.vue'
import Entrar from './components/auth/Entrar.vue'
import Perfil from './components/auth/profile/Perfil.vue'
import NovoProduto from './components/admin/NovoProduto.vue'
import Logout from './components/auth/Logout.vue'

export const routes = [

    {
        path: '/',
        component: Home
    },
    {
        path: '/Cadastrar',
        component: Cadastrar,
        meta: {
            requireVisitor: true
        }
    },
    {
        path: '/CarrinhoCompras',
        component: CarrinhoCompras,
        meta: {
            //requiresAuth: true
        }
    },
    {
        path: '/Admin',
        component: Admin,
        meta: {
            //requiresAdmin: true,
        }
    },
    {
        path: '/Entrar',
        component: Entrar,
        meta: {
            requireVisitor: true
        }
    },
    {
        path: '/Perfil',
        component: Perfil,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/NovoProduto',
        component: NovoProduto,
        meta: {
            //requiresAdmin: true
        }
    },
    {
        path: '/Logout',
        component: Logout,
        meta: {
            requiresAuth: true
        }
    }
]