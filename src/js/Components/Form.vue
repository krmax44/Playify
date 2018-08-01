<template>
	<form @submit.prevent="$emit('submit', e)">
		<slot></slot>
	</form>
</template>

<script>
export default {
	
}
</script>