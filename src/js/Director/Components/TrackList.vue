<template>
	<div class="tracklist">
		<Grid v-for="(track, i) in trackList" :key="i">
			<Column width="auto" v-if="!album"><img :src="track.image" class="cover"></Column>
			<Column width="*" class="meta">
				<p class="title"><Icon icon="track" /> {{ track.name }}</p>
				<p class="artist"><Icon icon="artist" /> {{ track.artist }}</p>
				<p class="album" v-if="!album"><Icon icon="album" /> {{ track.album.name }}</p>
			</Column>
			<Column width="auto" class="action"><Button @click="play(track)">Play</Button></Column>
		</Grid>
	</div>
</template>

<script>
import { Grid, Column, Icon, Link, Button } from '../../Components';

export default {
	props: ['tracks', 'album'],
	computed: {
		trackList() {
			return this.tracks.map(track => {
				if (!this.album) {
					if (track.album.images.length > 0) {
						track.image = track.album.images.sort((a, b) => a.width > b.width ? 1 : -1)[0].url;
					}
					else {
						track.image = '/static/icons/no-cover.svg';
					}
				}
				track.artist = track.artists.reduce((a, b) => a === '' ? b : `${a}, ${b}`, '');
				return track;
			});
		}
	},
	methods: {
		play(track) {
			this.$emit('play', track);
		}
	},
	components: { Grid, Column, Icon, Link, Button }
}
</script>

<style lang="scss" scoped>
@import '../../../style/variables.scss';

.tracklist {
	background-color: transparentize($dark, 0.25);

	.grid {
		position: relative;
		padding: 5px;
		margin-bottom: 7px;
		border-bottom: 2px $green solid;

		&::after {
			position: absolute;
			left: 10%;
			right: 10%;
			bottom: -5px;
			content: ' ';
			
		}

		&:last-child {
			border-bottom: none;
		}
	}

	.cover {
		height: 100%;
		width: auto;
	}

	.meta, .action {
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	.meta {
		.icon {
			opacity: .5;
			float: left;
		}

		p {
			margin: 0;
		}
	}
}
</style>