<template>
	<div class="col-lg-12" style="float:left">
		<br>
		<i v-bind="seImagemForNula"></i>
		<div class="card" v-if="qt.name">
			<img class="card-img-top" :src="dPath + image" alt="Cartão Imagem" style="width:200px;height:250px;">
			<div class="card-body">
				<h4 class="card-name form-control">{{qt.name}}</h4>
				<p class="card-text form-control">{{qt.email}}</p>
				<div>
					<strong class="card-text form-control">{{role}}</strong>
					</br>
				</div>
				<div>
					<a @click="editar" class="btn-primary form-control">Editar</a>
					<a @click="deletar" class="btn-btn-danger form-control">Deletar</a>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div>
					<input class="form-control vx" type="text" v-model="editValor">
					<input class="form-control vx" type="text" v-model="editEmail">
					<input class="form-control vx" type="password" v-model="editPassword" placeholder="Senha...">

					<select v-model="roleID" class="form-control vx">
						<option :value="1">admin</option>
						<option :value="2">usuario</option>
					</select>

					<img :src="dPath + image" alt="" class="img-responsive" :v-model="image" width="200px;">
					<input type="file" v-on:change="naMudancaArquivo">

					<a @click="atualizar" class="btn btn-primary vx">Salvar</a>
					<a @click="cancelar" class="btn btn-danger vx">Cancelar</a>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	name: 'Usuario',
	props: ['qt'],
	data() {
		return {
			editavel: false,
			role: '',
			roleID: this.qt.role_id,
			editValor: this.qt.name,
			editEmail: this.qt.email,
			editPassword: this.qt.password,
			image: this.qt.imagePath,
			path: 'produtoImagens/' + this.qt.imagePath,
			dPath: 'produtoImagens/'
		}
	},
	methods: {
		editar() {
			this.editavel = true
			this.editValor = this.qt.name
			this.editEmail = this.qt.email
			this.editPassword = ''
			this.roleID = this.qt.role_id

			if (this.qt.imagePath == null) {
				this.image = 'img.png'
			} else {
				this.image = this.qt.imagePath
			}
		},
		cancelar() {
			this.editavel = false
		},
		deletar() {
			this.qt.name = false 
			this.$Store.dispatch('DeletarUsuario', {
				id: this.qt.id
			})
			.then(response => {
				console.log(response);
			})
			.catch(error => {
				console.log(error);
			})
		},
		atualizar() {
			this.editavel = false 
			this.qt.role_id = this.roleID
			this.qt.name = this.editValor
			this.qt.email = this.editEmail
			this.qt.password = this.editPassword
			this.qt.imagePath = this.image 

			this.$store.dispatch('EditarUsuarios', {
				name: this.editValor,
				email: this.editEmail,
				password: this.editPassword,
				role_id: this.roleID,
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
					console.log(Object.values(error.response.data));
					this.ServerErrors = Object.values(error.response.data)
				}
			})
		},
		 naMudancaArquivo(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length) 
			
			return;
			
			this.criarImagem(files[0]);
			this.dPath = ''
		},
		 criarImagem(file) {
			let reader = new FileReader();
			let vm = this;
			reader.onload = (e) => {
				vm.image = e.target.result;
			};
			reader.readAsDataURL(file);
		}
	},
	computed: {
		seImagemForNula() {
			if (this.qt.imagePath == null) {
				this.image ='img.png'
			}
			if (this.qt.role_id == 1) {
				this.role = 'admin'
			}
			if (this.qt.role_id == 2) {
				this.role = 'user'
			}
		}
	}
}
</script>