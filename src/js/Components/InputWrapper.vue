<template>
	<div class="input-field" :class="classes">
		<slot />
	</div>
</template>

<script>
export default {
	props: ['classes']
}
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

.input-field {
	position: relative;

	&::before, &::after {
		content: ' ';
		position: absolute;
		bottom: 0;
		border-bottom: 2px $light solid;
		transition: .3s;
	}

	&::after {
		left: 50%;
		right: 50%;
		border-bottom: 2px $green solid;
	}

	&::before, &.focus::after {
		left: 0;
		right: 0;
	}

	&.dark {
		&::before {
			border-bottom-color: $dark;
		}
	}

	&.error {
		&::before, &::after {
			border-bottom-color: $red;
		}
	}
}
</style>