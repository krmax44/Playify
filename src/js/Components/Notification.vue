<template>
	<transition name="slide-up">
		<div class="notification" v-if="visible">
			<slot />
		</div>
	</transition>
</template>

<script>
export default {
	props: ['visible']
};
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

.notification {
	position: fixed;
	bottom: 0;
	left: 0;
	right: 0;
	z-index: 9;
	padding: 25px;
	background-color: $dark;

	.right {
		float: right;
	}
}
</style>
