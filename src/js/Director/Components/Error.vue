<template>
	<div class="error">
		<h2>Couldn't find that...</h2>
		<Button @click="openWithSpotify" dark="true">
			<Icon icon="spotify" /> Open with Spotify
		</Button>
	</div>
</template>

<script>
import { Button, Icon } from '../../Components';
export default {
	props: ['director'],
	methods: {
		openWithSpotify() {
			const url = new URL(this.director.originalUrl);
			url.hash = '#no-playify';
			window.location.href = url.href;
		}
	},
	components: { Button, Icon }
};
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
