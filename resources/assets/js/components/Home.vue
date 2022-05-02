<template>
	<div class="container" v-bind="getDado">
		<div class="col-lg-4" style="float: left" v-for="(qt, index) in produtos" :key="index">
			<br>
			<div class="card" v-if="qt.titulo">
				<img class="card-img-top" :src="dPath + qt.imagePath" alt="Cartão Imagem" style="width:100%;height:400px;">
				<div class="card-body">
					<h4 class="card-title">{{qt.titulo}}</h4>
					<p class="card-text">{{qt.description}}</p>
					<div>
						<strong class="card-text">Preço R$ {{qt.preco}}</strong>
					</div>
					<div>
						<a class="btn btn-primary" @click="AddNoCarrinho(qt.id, qt.preco)">Add no Carrinho</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'Home',
	data() {
		return {
			produtos: [],
			dPath: 'produtoImagens/'
		}
	},
	computed: {
		getDado() {
			this.$store.dispatch('ProdutoDado')
			.then(response => {
				console.log(response);
				this.produtos = this.$store.getters.ProdutoDado
				console.log(this.produtos);
			})
			.catch(error => {
				console.log(error);

				return false
			})
		}
	},
	methods: {
		AddNoCarrinho(id, preco) {
			const produtoId = id 
			const quantidade = 1
			const Preco = preco

			this.$store.dispatch('AddNoCarrinho', {
				id: produtoId,
				quantidade: 1,
				preco: Preco,
			})
			.then(response => {
				console.log(response);
			})
			.catch(error => {
				console.log(error);
			})
		}
	}
}
</script>