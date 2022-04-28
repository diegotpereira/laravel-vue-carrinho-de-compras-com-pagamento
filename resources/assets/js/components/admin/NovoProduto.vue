<template>
	<div class="row justify-content-md-center">
		<div class="col-lg-4 text-center">
			<br>
			<h3 style="font-family: fantasy;">Adicionar Novo Produto</h3>
			<div v-if="ServerErrors" class="alert-danger">
				<span class="alert-danger" v-for="(errors, index) in ServerErrors" :key="index">
					{{errors}}
				</span>
			</div>
			<form @submit.prevent="AddNovoProduto">
				<div>
					<div class="form-group">
						<label for="titulo">Titulo</label>
						<input type="text" v-validate="'required'" name="titulo" id="titulo" class="form-control" v-model="titulo">
						<span class="alert-danger"></span>
					</div>
					<div class="form-group">
						<label for="descricao">Descricao</label>
						<textarea type="text" v-validate="'required'" name="descricao" id="descricao" class="form-control" v-model="descricao"></textarea>
						<span class="alert-danger"></span>
					</div>
					<div class="form-group">
						<label for="preco">Preço</label>
						<input type="number" v-validate="'required'" name="preco" id="preco" class="form-control" v-model="preco">
						<span class="alert-danger"></span>
					</div>
					<div class="form-group">
						<img :src="imagePath" class="img-responsive col-lg-12">
						<input type="file" v-on:change="naMudancaArquivo">
					</div>
					<button type="submit" class="btn btn-primary">Adicionar</button>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
export default {
	name: 'NovoProduto',
	data() {
		return {
			titulo: '',
			descricao: '',
			preco: '',
			imagePath: '',
			ServerErrors: []
		}
	},
	methods: {
		AddNovoProduto() {
			this.$store.dispatch('AddNovoProduto', {
				titulo: this.titulo,
				descricao: this.descricao,
				preco: this.preco,
				imagePath: this.imagePath
			})
			.then(response => {
				this.$router.push({ path: '/Admin'})
			})
			.catch(error => {
				if (error.response.data.errors) {
					console.log(Object.values(error.response.data.errors));
					this.ServerErrors = Object.values(error.response.data.errors)
				} else {
					console.log(Object.values(error.response.data));
					this.ServerErrors = Object.values(error.response.data)
				}
			})
		},
		naMudancaArquivo(e) {
			let files = e.target.files || e.dataTransfer.files 

			if (!files.length) 

			return;

			this.criarImagem(files[0])
		},
		criarImagem(file) {
			let leitor = new FileReader()
			let vm = this; 
			leitor.onload = (e) => {
				vm.imagePath = e.target.result 
			}
			leitor.readAsDataURL(file)
		}
	}
}
</script>