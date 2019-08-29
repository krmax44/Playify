<template>
	<footer>
		<Container>
			<div>
				<LinkLabel href="https://krmax44.de" target="_blank"
					>&copy; krmax44</LinkLabel
				>
				<p>
					Spotify, Google, and other mentioned brands are not affiliated with
					this project.
				</p>
				<p>
					Photos from
					<LinkLabel href="https://unsplash.com" target="_blank"
						>Unsplash</LinkLabel
					>
				</p>
			</div>
		</Container>
	</footer>
</template>

<script>
import LinkLabel from './LinkLabel.vue';
import Container from './Container.vue';

export default {
	components: { LinkLabel, Container }
};
</script>

<style lang="scss">
@import '../../style/variables.scss';

footer {
	background-color: $dark;

	p {
		margin: 4px 0;
	}
}
</style>
