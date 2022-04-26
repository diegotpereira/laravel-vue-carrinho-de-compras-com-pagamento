<template>
	<div>
		<app-header />
		<div class="container">
			<div>
				<div class="text-center">
					<strong>Bem Vindo</strong>
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
			
		}
	},
	components: {
		appHeader: Header
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