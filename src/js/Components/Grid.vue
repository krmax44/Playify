<template>
	<div class="grid" :style="{ justifyContent, alignItems }">
		<slot></slot>
	</div>
</template>

<script>
export default {
	props: ['justifyContent', 'alignItems']
};
</script>

<style lang="scss">
.grid {
	display: flex;
	flex-wrap: wrap;

	.column:first-child {
		margin-left: 0 !important;
	}

	.column:last-child {
		margin-right: 0 !important;
	}
}
</style>
