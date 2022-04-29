<template>
	<div>
		<app-header></app-header>
		<div class="container">
			<div v-bind="usuarioDado">
				<div class="text-center" v-if="authDado">
					<strong>Bem Vindo {{authDado.name}}</strong>
				</div>
			</div>
			<transition name="slide" mode="out-in">
			   <router-view></router-view>
			</transition>
		</div>
	</div>
</template>
<script>
import Header from './components/Header.vue'
export default {
	name: 'App',
	data() {
		return {
			authDado: null
		}
	},
	components: {
		appHeader: Header
	},
	computed: {
		usuarioDado() {	
			this.$store.dispatch('usuarioDado')
			.then(response => {
				this.authDado = this.$store.getters.usuarioDado
				console.log(response);
				console.log(this.usuarioDado);
				return true
			})
			.catch(error => {
				this.authDado = ''
				console.log(error);

				return false
			})
		}
	}
}
</script>
<style>

.input-error{
  border:solid red  1px;
}
.dang{
  margin: 5px auto;
}

.slide-enter-active{
  animation:slide-in 200ms ease-out forwards;
}

.slide-leave-active {
  animation: slide-out 200ms ease-out forwards;
}

@keyframes slide-in {
  form {
    transform: translateY(-30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes slide-out {
  from {
    transform: translateY(0);
    opacity: 1;
  }
  to {
    transform: translateY(-30px);
    opacity: 0;
  }
}
</style>