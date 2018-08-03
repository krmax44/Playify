<template>
	<footer>
		<Container>
			<div>
				<Link href="https://krmax44.de" target="_blank">&copy; krmax44</Link>
				<p>Spotify, Google, and other mentioned brands are not affiliated with this project.</p>
				<p>Photos from <Link href="https://unsplash.com" target="_blank">Unsplash</Link></p>
			</div>
		</Container>
	</footer>
</template>

<script>
import Link from './Link.vue';
import Container from './Container.vue';

export default {
	components: { Link, Container }
}
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
