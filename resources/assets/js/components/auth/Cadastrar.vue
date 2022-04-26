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
			<form>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="form-control">
					<span class="alert-dander dang"></span>
				</div>
				<div class="form-group">
					<label for="nome">Nome</label>
					<input type="text" name="nome" id="nome" class="form-control">
					<span class="alert-dander dang"></span>
				</div>
				<div class="form-group">
					<label for="password">Senha</label>
					<input type="text" name="password" id="password" class="form-control">
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
			nome: '',
			password: ''
		}
	},
}
</script>