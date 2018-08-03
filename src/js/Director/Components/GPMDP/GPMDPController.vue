<template>
	<transition name="slide-up">
		<div class="gpmdp-controller" v-if="visible">
			<Grid>
				<Column width="*">
					<Grid>
						<Column width="auto">
							<img :src="data.track.albumArt" :title="data.track.album" class="cover-image">
						</Column>
						<Column width="*" class="meta">
							<p><Icon icon="track" /> {{ data.track.title }}</p>
							<p><Icon icon="artist" /> {{ data.track.artist }}</p>
							<p><Icon icon="album" /> {{ data.track.album }}</p>
						</Column>
					</Grid>
				</Column>
				<Column width="auto" class="actions">
					<Button inline="true" @click="prev"><Icon icon="prev" /></Button>
					<Button inline="true" @click="playPause"><Icon :icon="data.playState === 'playing' ? 'pause' : 'play'" /></Button>
					<Button inline="true" @click="next"><Icon icon="next" /></Button>
				</Column>
				<Column width="*" class="progress">
					<p>{{ progress }}</p>
				</Column>
			</Grid>
		</div>
	</transition>
</template>

<script>
import { Grid, Column, Icon, Button } from '../../../Components';
import GPMDP from '../../../GPMDP';
export default {
	props: ['data'],
	computed: {
		visible() {
			if (this.data.playState !== 'stopped' && this.data.track !== null && this.data.progress !== null) {
				document.body.classList.add('padding-bottom');
				return true;
			}
			else {
				document.body.classList.remove('padding-bottom');
				return false;
			}
		},
		progress() {
			const secondsToTime = (milliseconds) => { // https://stackoverflow.com/a/7579799
				const seconds = Math.floor(milliseconds / 1000);
				const h = Math.floor(seconds / 3600);
				const m = Math.floor((seconds % 3600) / 60);
				const s = seconds % 60;
				return [
					h,
					m > 9 ? m : (h ? '0' + m : m || '0'),
					s > 9 ? s : '0' + s,
				].filter(a => a).join(':');
			};

			const current = secondsToTime(this.data.progress.current);
			const total = secondsToTime(this.data.progress.total);
			
			return `${current} / ${total}`;
		}
	},
	methods: {
		playPause() {
			GPMDP.playPause();
		},
		prev() {
			GPMDP.prev();
		},
		next() {
			GPMDP.next();
		}
	},
	components: { Grid, Column, Icon, Button }
}
</script>

<style lang="scss" scoped>
@import '../../../../style/variables.scss';

.gpmdp-controller {
	position: fixed;
	bottom: 0;
	left: 0;
	right: 0;
	z-index: 10;
	background-color: $dark;
	box-shadow: 0 -2px 8px $green;

	.grid {
		align-items: center;
		justify-content: center;
	}

	.column {
		margin: 0 5px;
	}

	.cover-image {
		height: 100px;
	}

	.meta {
		img.icon {
			opacity: .5;
		}

		p {
			margin: 0;
		}
	}

	.actions {
		text-align: center;

		.icon {
			margin: 0;
		}
	}

	.progress {
		text-align: right;
		padding-right: 15px;
	}
}
</style>