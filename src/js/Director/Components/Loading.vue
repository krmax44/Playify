<template>
	<div class="loading">
		<Icon icon="playify" height="100%"/>
	</div>
</template>

<script>
import { Icon } from '../../Components';

export default {
	components: { Icon }
}
</script>

<style lang="scss" scoped>
@import '../../../style/variables.scss';

.loading {
	max-width: 25vw;
	width: 100%;

	img {
		width: 100%;
		animation: loading 2s infinite ease-in-out;
	}
}

@keyframes loading {
	0% {
		transform: rotate(0deg) scale(1);
	}
	50% {
		transform: rotate(10deg) scale(1.1);
	}
	100% {
		transform: rotate(0deg) scale(1);
	}
}
</style>