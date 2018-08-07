<template>
	<div>
		<div class="info">		
			<h2>{{ data.name }}</h2>
			<h3>{{ data.creator }}</h3>
			<p>{{ data.description }}</p>
			<Button inline="true" @click="transfer"><Icon icon="transfer" /> Transfer playlist</Button>
		</div>

		<TrackList :tracks="data.tracks" @play="play" />
	</div>
</template>

<script>
import { Grid, Column, Button, Icon } from '../../Components';
import TrackList from './TrackList.vue';

export default {
	props: ['data'],
	methods: {
		play(track) {
			this.$emit('play', track);
		},
		transfer() {
			this.$emit('transfer');
		}
	},
	components: { TrackList, Grid, Column, Button, Icon }
}
</script>

<style lang="scss" scoped>
.info {
	text-align: center;
	padding: 10px 0;

	h2, h3 {
		margin: 2px 0;
	}
}
</style>