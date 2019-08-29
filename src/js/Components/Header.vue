<template>
	<header>
		<h1><slot></slot></h1>
	</header>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

header {
	width: 100%;
	padding: 10px 0;
	text-align: center;
	background-color: $dark;

	h1 {
		margin: 0;
	}
}
</style>
