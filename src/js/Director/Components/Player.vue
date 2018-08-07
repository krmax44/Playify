<template>
	<div class="player">
		<Playlist v-if="director.type === 'playlist'" :data="data" @play="play" @transfer="transfer" />
		<Album v-if="director.type === 'album'" :data="data" @play="play" />
		<Artist v-if="director.type === 'artist'" :data="data" @play="play" />
		<Track v-if="director.type === 'track'" :data="data" @play="play" />
	</div>
</template>

<script>
import Playlist from './Playlist.vue';
import Album from './Album.vue';
import Artist from './Artist.vue';
import Track from './Track.vue';

export default {
	props: ['data', 'director', 'service'],
	methods: {
		play(data) {
			this.$emit('play', data);
		},
		transfer() {
			this.$emit('transfer');
		}
	},
	components: { Playlist, Album, Artist, Track }
}
</script>

<style lang="scss" scoped>
.player {
	display: flex;

	&, & > div {
		flex: 1;
		min-height: 100%;
		width: 100%;
	}
}
</style>