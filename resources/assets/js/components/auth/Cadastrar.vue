<template>
	<div class="row justify-content-md-center">
		<div class="collg-4 text-center">
			<br>
			<h3 style="font-family: fantasy;">Inscreva-se para Registrar nova conta</h3>
			<div class="alert-danger">
				<span class="alert-danger">
					{{ errors }}
				</span>
			</div>
			<form @submit.prevent="registrar">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" v-validate="'required|email'" name="email" id="email" class="form-control" v-model="email" >
					<span class="alert-dander dang"></span>
				</div>
				<div class="form-group">
					<label for="name">Nome</label>
					<input type="text" v-validate="'required'" name="name" id="name" class="form-control" v-model="name"  >
					<span class="alert-dander dang"></span>
				</div>
				<div class="form-group">
					<label for="password">Senha</label>
					<input type="password" v-validate="'required|min:6'" name="password" id="password" class="form-control" v-model="password"  >
					<span class="alert-dander dang"></span>
				</div>
				<button class="btn btn-romary">Cadastrar</button>
			</form>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			email: '',
			name: '',
			password: '',
			ServerErrors: []
		}
	},
	methods: {
		registrar() {
			this.$store.dispatch('registrar', {
				email: this.email,
				name: this.name,
				password: this.password
			})
			.then(response => {
				this.$router.push({ path: '/Entrar'})
			})
			.catch(error => {
				if (error.response.data.errors) {
					console.log(Object.values(error.response.data.errors));
					this.ServerErrors = Object.values(error.response.data.errors)
				} else {
					console.log(Object.values(error.response.data));
					this.ServerErrors = Object.values(error.response.data)
				}
				this.password = ''
			})
		}
	}
}
</script>