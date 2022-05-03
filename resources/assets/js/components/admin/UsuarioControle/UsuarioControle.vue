<template>
	<div>
		<div class="container">
			<div class="row">
				<button class="btn btn-primary col-md-6" @click="getUsuarios">Buscar Usuários</button>
				<router-link tag="button"
				             class="btn btn-warning col-md-6"
							 to="/NovoUsuario">
					Add Novo Usuário
				</router-link>
			</div>

			<app-usuario
			      v-for="user in users" :key="user.id"
				  :qt="user">

			</app-usuario>
		</div>
	</div>
</template>
<script>
import Usuario from './Usuario.vue'
export default {
	name: 'UsuarioControle',
	data() {
		return {
			users: []
		}
	},
	methods: {
		getUsuarios() {
			this.$store.dispatch('TodosUsuarios')
			.then(response => {
				this.users = this.$store.getters.TodosUsuarios
				console.log(this.users);
			})
			.catch(error => {
				console.log(error);

				return false
			})
		}
	},
	components: {
		'app-usuario': Usuario
	}
}
</script>