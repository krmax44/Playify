<template>
	<div class="error">
		<h2>Couldn't find that...</h2>
		<Button @click="openWithSpotify" dark="true"><Icon icon="spotify" /> Open with Spotify</Button>
	</div>
</template>

<script>
import { Button, Icon } from '../../Components';
export default {
	props: ['director'],
	methods: {
		openWithSpotify() {
			const parser = document.createElement('a');
			parser.href = this.director.originalUrl;
			parser.hash = '#no-playify';
			window.location.href = parser.href;
		}
	},
	components: { Button, Icon }
}
</script>

<style lang="scss" scoped>
.error {
	display: flex;
	flex: 1;
	flex-direction: column;
	width: 100%;
	height: 100%;
	justify-content: center;
	align-items: center;
}
</style>