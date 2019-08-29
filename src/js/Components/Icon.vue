<template>
	<img
		class="icon"
		:src="'static/icons/' + icon + '.svg'"
		:style="{ height: height ? height : '18px' }"
		:class="{ black }"
	/>
</template>

<script>
export default {
	props: ['icon', 'height', 'black']
};
</script>

<style lang="scss" scoped>
img.icon {
	width: auto;
	margin: 0 5px;

	&.black {
		filter: invert(1);
	}
}

.btn > .icon {
	margin-left: 0;
}
</style>
