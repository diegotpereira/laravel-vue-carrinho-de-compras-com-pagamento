<template>
	<div class="col-lg-4" style="float:left">
		<br>
		<div class="card" v-if="qt.titulo">
			<img class="card-img-top" :src="dPath + image" alt="Cartão Imagem" style="width:100¨%; height:400px">
			<div class="card-body">
				<h4 class="card-title">{{qt.titulo}}</h4>
				<p class="card-text">{{qt.descricao}}</p>
				<div>
					<strong class="card-text">Preço R$ {{qt.preco}} </strong>
				</div>
				<div v-if="!editavel">
					<a @click="editar" class="btn btn-primary">Editar</a>
					<a @click="deletar" class="btn btn-danger">Deletar</a>
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

					<a @click="atualizar" class="btn btn-primary vx">Salvar</a>
					<a @click="cancelar" class="btn btn-danger vx">Cancelar</a>
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
		editar() {
			this.editavel = true,
			this.editValor = this.qt.titulo,
			this.editDesc = this.qt.descricao,
			this.editPreco = this.qt.preco,
			this.image = this.qt.imagePath
		},
		atualizar() {
			this.editavel = false,
			this.qt.titulo = this.editValor,
			this.dt.descricao = this.editDesc,
			this.qt.preco = this.editPreco,
			this.qt.imagePath = this.image

			this.$store.dispatch('EditarProduto', {
				titulo: this.editValor,
				descricao: this.editDesc,
				preco: this.editPreco,
				imagePath: this.image,
				id: this.qt.id
			})
			.then(response => {
				console.log(response);
			})
			.catch(error => {
				if (error.response.data.errors) {
					console.log(Object.values(error.response.data.errors));
					this.ServerErrors = Object.values(error.response.data.errors)
				} else {
					console.log(Objcet.values(error.response.data));
					this.ServerErrors = Object.values(error.response.data)
				}
			})
		},
		deletar() {
			this.qt.titulo = false 

			this.$store.dispatch('DeletarProduto', {
				id: this.qt.id
			})
			.then(response => {
				console.log(response);
			})
			.catch(error => {
				console.log(error);
			})
		},
		cancelar() {
			this.editavel = false
		},
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