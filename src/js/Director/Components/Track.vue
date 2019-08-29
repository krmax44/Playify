<template>
	<Grid>
		<Column width="*">
			<h1>{{ data.name }}</h1>
			<h2>{{ artist }}</h2>
			<h2>{{ data.album.name }}</h2>
			<Button inline="true" @click="play"><Icon icon="play" /> Play</Button>
		</Column>
	</Grid>
</template>

<script>
import { Grid, Column, Button, Icon } from '../../Components';

export default {
	props: ['data'],
	computed: {
		artist() {
			return this.data.artists.reduce(
				(a, b) => (a === '' ? b : `${a}, ${b}`),
				''
			);
		}
	},
	created() {
		if (this.data.album.images.length > 0) {
			const image = this.data.album.images.sort((a, b) =>
				a.width < b.width ? 1 : -1
			)[0].url;
			document.body.style.backgroundImage = `url(${image})`;
			document.body.classList.add('background-tiles');
		}
	},
	methods: {
		play() {
			this.$emit('play', this.data);
		}
	},
	components: { Grid, Column, Button, Icon }
};
</script>

<style lang="scss" scoped>
@import '../../../style/variables.scss';

.grid {
	justify-content: center;
	align-items: center;
	min-height: 100%;
	text-align: center;

	h1,
	h2 {
		text-shadow: 0 0 10px $dark;
		margin: 0;
	}

	h1 {
		font-size: 3em;
	}

	h2 {
		font-size: 2em;
	}

	.btn-mask {
		margin-top: 2em;
	}
}
</style>
