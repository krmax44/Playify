<template>
	<div class="container">
		<slot></slot>
	</div>
</template>

<style lang="scss" scoped>
@import '../../style/variables.scss';

.container {
	display: flex;
	flex-direction: column;
	padding: 10px;
	max-width: $container-max-width;
	width: 100%;
	margin: auto;
}
</style>
