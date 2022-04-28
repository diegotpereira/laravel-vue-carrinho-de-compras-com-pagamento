<template>
	<div class="col-lg-4" style="float:left">
		<br>
		<div class="card" v-if="qt.titulo">
			<img class="card-img-top" :src="dPath + image" alt="Cartão Imagem" style="width:100¨%; height:400px">
			<div class="card-body">
				<h4 class="card-title">{{qt.titulo}}</h4>
				<p class="card-text">{{qt.descricao}}</p>
				<div>
					<strong class="card-text">Preço{{qt.preco}}R$</strong>
				</div>
				<div v-if="!editavel">
					<a href=""></a>
					<a href=""></a>
				</div>
			</div>
		</div>
		<div class="card" v-if="editavel">
			<div class="card-body">
				<div>
					<input class="form-control vx" type="text" v-model="editValor">
					<input class="form-control vx" type="text" v-model="editDesc">
					<input class="form-control vx" type="text" v-model="editPreco">

					<img :src="dPath + image" class="img-responsive" alt="" :v-model="image" width="200px;">

					<input type="file" name="" id="" class="form-control">

					<a href=""></a>
					<a href=""></a>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'Produto'
}
</script>