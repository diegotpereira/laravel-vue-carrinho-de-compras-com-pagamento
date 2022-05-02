<template>
	<div>
		<i v-bind="getCarrinhoItens"></i>
		<div class="col-lg-3" style="float: left" v-for="(qt, index) in data" :key="index">
			<br>
			<div class="card" v-if="qt.titulo">
				<i v-on="lixeiraDoCarrinho(qt.id, qt.preco)" class="fa fa-times" id="del" aria-hidden="true"></i>
				<hr>
				<img class="card-img-top" :src="dPath + qt.imagePath" alt="Cartão Imagem" style="width:100%;height:200px;">
				<div class="card-body">
					<h4 class="text-center">quantidade x {{quantidade}}</h4>
					<hr>
					<h4 class="card-title">{{qt.titulo}}</h4>
					<p class="card-text">{{qt.descricao}}</p>
					<div>
						<strong class="card-text">Preço R$ {{qt.preco}}</strong>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'CheckOut',
	props: ['id', 'quantidade'],
	data() {
		return {
			data: [],
			dPath: 'produtoImagens/'
		}
	},
	computed: {
		getCarrinhoItens() {
			this.$store.dispatch('getCarrinhoItens', {
				id: this.id
			})
			.then(response => {
				this.data = response.data 
			})
			.catch(error => {
				console.log(error);
			})
		}
	},
	methods: {
		lixeiraDoCarrinho(id, preco) {
			const produtoId = id
			const quantidade = 1
			const Preco = preco

			this.$store.dispatch('lixeiraDoCarrinho', {
				id: produtoId,
				quantidade: 1,
				preco: Preco
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