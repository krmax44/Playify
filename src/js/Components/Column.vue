<template>
	<div :style="{ flex: f, width: w }" class="column">
		<slot />
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
	computed: {
		w() {
			return this.width !== '*' ? this.width : 'auto';
		},
		f() {
			return this.flex || (this.width !== '*' ? '0 0 auto' : '1 1 0');
		}
	}
};
</script>

<style lang="scss" scoped>
.column {
	margin: 5px;
}
</style>
