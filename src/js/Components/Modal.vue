<template>
	<div class="modal" :class="{ open }" @click="close" @keyup.esc="close">
		<div class="modal-inner">
			<slot />
		</div>
	</div>
</template>

<script>
export default {
	props: {
		open: {
			default: false,
			type: Boolean
		},
		closeable: {
			default: true,
			type: Boolean
		}
	},
	methods: {
		close(e) {
			if (this.closeable && e.target.classList.contains('modal')) {
				this.$emit('close');
			}
		}
	}
};
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

.modal {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	position: fixed;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	width: 100vw;
	height: 100vh;
	z-index: 99;
	background-color: transparent;
	pointer-events: none;
	transition: background-color 0.5s;

	.modal-inner {
		max-width: $container-max-width;
		width: 90%;
		max-height: 80vh;
		overflow: auto;
		padding: 5px;
		opacity: 0;
		background-color: $light;
		color: $dark !important;
		transform: translateY(-100vh);
		transition: 0.5s;
	}

	&.open {
		pointer-events: auto;
		background-color: transparentize($dark, 0.05);

		.modal-inner {
			transform: translateY(0);
			opacity: 1;
		}
	}
}
</style>
