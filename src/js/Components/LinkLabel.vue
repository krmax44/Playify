<template>
	<a :href="href || '#!'" :target="target || ''" @click="click" :class="{ link: true, constant }">
		<slot />
	</a>
</template>

<script>
export default {
	props: ['href', 'target', 'constant'],
	methods: {
		click(e) {
			this.$emit('click', e);
		}
	}
}
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

a.link {
	color: $green;
	padding: 0;
	background-color: transparent;
	text-decoration: none;
	transition: .3s;

	&.constant {
		padding: 0 4px;
	}

	&:hover, &.constant {
		background-color: $green;
		color: $light;
	}

	&:hover {
		padding: 0 5px;
	}
}
</style>
