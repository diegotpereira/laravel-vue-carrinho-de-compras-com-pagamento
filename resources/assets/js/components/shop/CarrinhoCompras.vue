<template>
	<div>
		<i v-bind="getCarrinhoItens"></i>

		<app-verificar
		  v-for="produto in produtos"
		  :id="produto.id"
		  :quantidade="produto.quantidade"
		  :key="produto.id">

		</app-verificar>

		<div class="clear"></div>

		<button @click="CheckOut" type="submit" class="btn btn-primary form-control CheckOut">Comprar Agora</button>
	</div>
</template>
<script>
import Checkout from './CheckOut.vue'
export default {
	name: 'CarrinhoCompras',
	data() {
		return {
			produtos: []
		}
	},
	computed: {
		getCarrinhoItens() {
			this.produtos = this.$store.getters.carrinhoNumero
		}
	},
	methods: {
		CheckOut() {
			const Preco = this.$store.getters.precoTotal
			this.$store.dispatch('Verificar', {
				preco: Preco
			})
			.then(response => {
				this.data = response.data
			})
			.catch(error => {
				console.log(error);
			})
		}
	},
	components: {
		'app-verificar' : Checkout
	}
}
</script>
<style scoped>
  #del{
    font-size: 20px;
    margin: 5px auto;
    cursor: pointer;
  }
  #del:hover{
    color: red;
  }
  .clear{
    width: 100%;
    height: 1px;
    clear: both;
  }
  .CheckOut{
        cursor: pointer;
  }

</style>