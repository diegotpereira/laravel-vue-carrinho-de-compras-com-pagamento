<template>
	<div class="row justify-content-md-center">
		<div class="col-lg-4 text-center">
			<br>
			<h3 style="font-family: fantasy;">Entrar</h3>
			<div v-if="ServerErrors" class="alert-danger">
				<span class="alert-danger" v-for="(errors, index) in ServerErrors" :key="index">
					{{errors[0]}}
				</span>
			</div>
			<form @submit.prevent="enviar">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="username" id="username" class="form-control" v-model="username"  >
					<span class="alert-danger dang"></span>
				</div>
				<div class="form-group">
					<label for="password">Senha</label>
					<input type="password" name="password" id="password" class="form-control" v-model="password" >
					<span class="alert-danger dang"></span>
				</div>
				<button class="btn btn-primary">Entrar</button>
			</form>
		</div>
	</div>
</template>
<script>
export default {
	name: 'Entrar',
	data() {
		return {
			username: '',
			password: '',
			ServerErrors: []
		}
	},
	methods: {
		enviar() {
			this.$store.dispatch('recuperarToken', {
				username: this.username,
				password: this.password
			})
			.then(response => {
				setTimeout(this.$router.push({path: 'Perfil'}), 3000)
			})
			.catch(error => {
				if (error.response.data.errors) {
					this.ServerErrors = Object.values(error.response.data.errors)
					console.log(Object.values(error.response.data.errors));
				} else {
					this.ServerErrors = Array(Array(error.response.data))
					console.log(Array(Array(error.response.data)));
				}
				this.password = ''
			})
		}
	}
}
</script>