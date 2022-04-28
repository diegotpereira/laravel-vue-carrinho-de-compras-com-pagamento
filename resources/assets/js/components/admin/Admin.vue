<template>
	<div>
		<div class="container">
			<div class="row">
				<button class="btn-btn-primary col-md-6">Buscar Produtos</button>
				<router-link tag="button" class="btn btn-warning col-md-6" to="/NovoProduto">
				    Novo Produto
				</router-link>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'Admin'
}
</script>