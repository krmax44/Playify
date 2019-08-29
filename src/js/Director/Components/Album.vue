<template>
	<div>
		<div class="info">
			<h2>{{ data.name }}</h2>
			<h3>{{ artist }}</h3>
			<Button inline="true" @click="playAlbum"
				><Icon icon="play" /> Play</Button
			>
		</div>

		<TrackList album="true" :tracks="data.tracks" @play="play" />
	</div>
</template>

<script>
import { Button, Icon } from '../../Components';
import TrackList from './TrackList.vue';

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
		if (this.data.images.length > 0) {
			const image = this.data.images.sort((a, b) =>
				a.width < b.width ? 1 : -1
			)[0].url;
			document.body.style.backgroundImage = `url(${image})`;
			document.body.classList.add('background-tiles');
		}
	},
	methods: {
		play(data) {
			this.$emit('play', data);
		},
		playAlbum() {
			const data = this.data;
			this.$emit('play', { type: 'album', ...data });
		}
	},
	components: { Button, Icon, TrackList }
};
</script>

<style lang="scss" scoped>
@import '../../../style/variables.scss';

.info {
	text-align: center;
	padding: 10px 0;

	h2,
	h3 {
		margin: 2px 0;
		text-shadow: 0 0 10px $dark;
	}
}
</style>
