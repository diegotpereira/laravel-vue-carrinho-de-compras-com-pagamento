<template>
	
</template>
<script>
export default {
	name: 'Logout',
	created() {
		this.$store.dispatch('destroirToken')
		.then(response => {
			this.$router.push({path: '/'})
		})
	}
}
</script>