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
			      v-for="usuario in usuarios" :key="usuario.id"
				  :qt="usuario">

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
			usuarios: []
		}
	},
	methods: {
		getUsuarios() {
			this.$store.dispatch('TodosUsuarios')
			.then(response => {
				this.usuarios = this.$store.getters.TodosUsuarios
				console.log(this.usuarios);
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