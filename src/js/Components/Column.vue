<template>
	<div
		:style="{ flex: flex || (width !== '*' ? '0 1 0' : '1 1 0'), width: width !== '*' ? width : 'auto' }"
		class="column">
		<slot></slot>
	</div>
</template>

<script>
export default {
	props: {
		width: {
			default: 'auto',
			type: String
		},
		flex: {
			default: '',
			type: String
		}
	},
}
</script>

<style lang="scss" scoped>
.column {
	margin: 5px;
}
</style>