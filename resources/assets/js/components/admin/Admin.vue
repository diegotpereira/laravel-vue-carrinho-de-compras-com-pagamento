<template>
	<div>
		<div class="container">
			<div class="row">
				<button class="btn-btn-primary col-md-6" @click="buscarProdutos">Buscar Produtos</button>
				<router-link tag="button" class="btn btn-warning col-md-6" to="/NovoProduto">
				    Novo Produto
				</router-link>
			</div>
			<app-produto
				v-for="(produto, index) in produtos" 
				:q="produto"
				:key="index">
			</app-produto>
		</div>
	</div>
</template>
<script>
import Produto from './Produto.vue'
export default {
	name: 'Admin',
	data() {
		return {
			produtos: []
		}
	},
	components: {
		'app-produto': Produto
	},
	methods: {
		buscarProdutos() {
			this.$store.dispatch('ProdutoDado')
			.then((response) => {
				this.produtos = this.$store.getters.ProdutoDado
				console.log(this.produtos);
			}).catch((err) => {
				console.log(err);

				return false
			});
		}
	}
}
</script>