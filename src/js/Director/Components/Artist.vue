<template>
	<div>
		<h1>{{ data.name }}</h1>

		<h2>Top Songs</h2>
		<TrackList :tracks="data.tracks" @play="play" />

		<h2>Top Albums</h2>
		<Grid class="albums">
			<Column v-for="album in albums" :key="album.name" width="auto" flex="1" class="album">
				<img :src="album.image" :title="album.name" class="cover">
				<div class="overlay">
					<Button inline="true" dark="true" @click="playAlbum(album)"><Icon icon="play" /> Play</Button>
					<Button inline="true" dark="true" @click="openAlbum(album)"><Icon icon="playify-note" /> Open</Button>
				</div>
			</Column>
		</Grid>
	</div>
</template>

<script>
import { Grid, Column, Button, Icon } from '../../Components';
import TrackList from './TrackList.vue';

export default {
	props: ['data'],
	created() {
		console.log(this.data);
	},
	computed: {
		albums() {
			return this.data.albums.map(album => {
				album.image = album.images[1].url || '/static/icons/no-cover.svg';
				return album;
			});
		}
	},
	methods: {
		play(data) {
			this.$emit('play', data);
		},
		playAlbum(data) {
			data.artists = [this.data.name];
			this.$emit('play', { type: 'album', ...data })
		},
		openAlbum(data) {
			const parser = document.createElement('a');
			parser.href = chrome.extension.getURL('index.html');
			parser.hash = '#' + JSON.stringify({
				type: 'album',
				id: data.id
			});
			window.open(parser.href, '_blank');
		}
	},
	components: { Grid, Column, Button, Icon, TrackList }
}
</script>

<style lang="scss" scoped>
@import '../../../style/variables.scss';

h1 {
	text-align: center;
}

.albums {
	flex-wrap: nowrap;

	.album {
		position: relative;
		cursor: pointer;

		img.cover {
			width: 100%;
		}

		.overlay {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background-color: transparentize($dark, .5);
			opacity: 0;
			transition: .3s;
		}

		.btn-mask {
			width: 80%;
		}

		&:hover .overlay {
			opacity: 1;
		}
	}
}
</style>