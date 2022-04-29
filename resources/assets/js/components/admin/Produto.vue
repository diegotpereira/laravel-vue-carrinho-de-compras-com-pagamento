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
					<a href="" class="btn btn-primary">Editar</a>
					<a href="" class="btn btn-danger">Deletar</a>
				</div>
			</div>
		</div>
		<div class="card" v-if="editavel">
			<div class="card-body">
				<div>
					<input class="form-control vx" type="text" v-model="editValor">
					<input class="form-control vx" type="text" v-model="editDesc">
					<input class="form-control vx" type="text" v-model="editPreco">

					<!--<img :src="dPath + image" class="img-responsive" v-model="image" width="200px;">-->

					<input type="file" v-on:change="mudarArquivo" class="form-control">

					<a href=""></a>
					<a href=""></a>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'Produto',
	props: ['qt'],
	data() {
		return {
			editavel: false,
			editValor: this.qt.titulo,
			editDesc: this.qt.descricao,
			editPreco: this.qt.preco,
			image: this.qt.imagePath,
			path: 'produtoImagens/' + this.qt.imagePath,
			dPath: 'produtoImagens/',
		}
	},
	methods: {
		mudarArquivo(e) {
			let files = e.target.files || e.dataTransfer.files
			if (!files.length) 
			return;

			this.criarImagem(files[0])
			this.dPath = ''
		},
		criarImagem(file) {
			let reader = new FileReader()
			let vm = this;
			reader.onload = (e) => {
				vm.image = e.targer.result
			}
			reader.readAsDataURL(file)
		}
	}
}
</script>