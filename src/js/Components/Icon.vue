<template>
	<img class="icon" :src="'static/icons/' + icon + '.svg'" :style="{ height: height ? height : '18px' }">
</template>

<script>
export default {
	props: ['icon', 'height']
}
</script>

<style lang="scss" scoped>
img.icon {
	width: auto;
	margin: 0 5px;
}

.btn > .icon {
	margin-left: 0;
}
</style>