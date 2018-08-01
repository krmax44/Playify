<template>
	<div class="page">
		<Header>{{ title }}</Header>
		<Container :style="{ justifyContent, alignItems }">
			<slot/>
		</Container>
		<Footer/>
	</div>
</template>

<script>
import Header from './Header.vue';
import Container from './Container.vue';
import Footer from './Footer.vue';

export default {
	props: ['title', 'justifyContent', 'alignItems'],
	components: { Header, Container, Footer }
}
</script>

<style lang="scss" scoped>
.page {
	display: flex;
	flex-direction: column;
	min-height: 100vh;

	.container {
		flex: 1;
	}
}
</style>
