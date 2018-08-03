<template>
	<div :class="{ 'btn-mask': true, block: !inline }">
		<a :href="href || '#!'" :target="target || ''" @click="click" :class="{ btn: true, dark }">
			<span><slot /></span>
		</a>
	</div>
</template>

<script>
export default {
	props: ['href', 'target', 'inline', 'dark'],
	methods: {
		click(e) {
			this.$emit('click', e);
		}
	}
}
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

.btn-mask {
	display: inline-flex;
	margin: 5px 0;
	border-radius: 100px;
	overflow: hidden;

	&.block {
		display: flex;
	}
}

.btn {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	position: relative;
	padding: 10px 30px;
	color: $light;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;

	span {
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 1;
	}

	img.icon {
		margin-left: 0;
	}

	&::before, &::after {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		width: 100%;
		height: 100%;
		content: ' ';
		background-color: $green;
		z-index: 0;
	}

	&.dark::before {
		background-color: $dark;
	}

	&::after {
		height: 0;
		transition: .2s;
		background-color: rgba(0,0,0,.05);
	}

	&.dark::after {
		background-color: rgba(255,255,255,.1);
	}

	&:hover::after {
		height: 100%;
	}
}
</style>