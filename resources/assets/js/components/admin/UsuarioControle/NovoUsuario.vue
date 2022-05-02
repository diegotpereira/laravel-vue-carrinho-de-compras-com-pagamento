<template>
	<div class="row justify-content-md-center">
		<div class="col-lg-4 text-center">
			<br>
			<h3 style="font-family: fantasy;">Add Novo Usuário</h3>
			<div v-if="ServerErrors" class="alert-danger">
				<span class="alert-danger" v-for="(errors, index) in ServerErrors" :key="index">
					{{errors[0]}}
				</span>
			</div>
			<form @submit.prevent="AddNovoUsuario" class="col-lg-12">
				<div>
					<div class="form-group">
						<label for="name">Nome</label>
						<input type="text" v-validate="'required'" name="name" id="name" class="form-control" v-model="name">
						<span class="alert-danger dang">{{errors.first('name')}}</span>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" v-validate="'required'" name="email" id="email" class="form-control" v-model="email">
						<span class="alert-danger dang">{{errors.first('email')}}</span>
					</div>
					<div class="form-group">
						<label for="password">Senha</label>
						<input type="text" v-validate="'required'" name="password" id="password" class="form-control" v-model="password">
						<span class="alert-danger dang">{{errors.first('password')}}</span>
					</div>
					<div class="form-group">
						<label for="roleID">Função</label>
						<select id="roleID" v-model="role_id" class="form-control vx">
							<option :value="1">admin</option>
							<option :value="2">usuário</option>
						</select>
					</div>
					<div class="form-group">
						<img :src="imagePath" v-model="imagePath" class="img-responsive col-lg-12">
						<input type="file" v-on:change="naMudancaArquivo">
					</div>
					<button class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
export default {
	name: 'NovoUsuario',
	data() {
		return {
			name: '',
			email: '',
			password: '',
 			imagePath: '',
 			role_id: 2,
 			ServerErrors: [],
		}
	},
	methods: {
		AddNovoUsuario() {
			this.$store.dispatch('AddNovoUsuario', {
				name: this.name,
				email: this.email,
			    password: this.password,
	    		imagePath: this.imagePath,
	    		role_id: this.role_id,	
			})
			.then(response => {
				console.log(response);
				this.$router.push({path: '/UsuarioControle'})
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
			//this.dPath = ''
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