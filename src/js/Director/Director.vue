<template>
	<Page title="Playify" :justifyContent="loading ? 'center' : ''" :alignItems="loading ? 'center' : ''">
		<Loading v-if="loading"/>
		<div v-if="!loading">
			<div v-if="director.type === 'playlist'">
				<Playlist :data="data" @play="play" />
			</div>
			<div v-else-if="service.id === 'gpmdp'">
				<Album v-if="director.type === 'album'" :data="data" />
				<Artist v-if="director.type === 'artist'" :data="data" />
				<Track v-if="director.type === 'track'" :data="data" />
			</div>
		</div>

		<GPMDPController v-if="service.id === 'gpmdp'" :data="gpmdpStates" />

		<SetupGPMDP :open="gpmdpSetup.open" :failed="gpmdpSetup.failed" @save="authenticate" />
	</Page>
</template>

<script>
import Settings from '../Settings';
import components from '../Components';
import directorComponents from './Components';
import LinkBuilder from '../LinkBuilder';
import SetupGPMDP from '../Setup/SetupGPMDP.vue';
import GPMDP from '../GPMDP';
import axios from 'axios';
const backend = 'http://localhost:3000'

export default {
	data() {
		return {
			loading: true,
			fetching: true,
			page: 0,
			error: false,
			director: {},
			data: {},
			service: {},
			gpmdpSetup: {
				open: false,
				failed: false
			},
			gpmdpStates: {
				track: null,
				playState: null,
				progress: null
			}
		}
	},
	created() {
		Settings.subscribe(settings => {
			Settings
				.get()
				.then(settings => {
					this.service = settings.service;
				});
		}, true);

		Settings
			.get()
			.then(settings => {
				this.service = settings.service;
				this.director = settings.director;
				const { id, userId, type } = settings.director;

				axios
					.get(`${backend}/${type}`, {
						params: { id, userId }
					})
					.then(response => {
						this.fetching = false;
						const data = response.data;

						if (data.error === true) {
							return Promise.reject(data.errorMsg);
						}

						if (settings.service.id === 'gpmdp') {
							const gpmdp = GPMDP.connect();
							gpmdp.addEventListener('codeRequired', () => {
								this.gpmdpSetup.open = true;
							});
							gpmdp.addEventListener('authFailed', () => {
								this.gpmdpSetup.open = true;
								this.gpmdpSetup.failed = true;
							});
							gpmdp.addEventListener('authSuccess', () => {
								this.gpmdpSetup.open = false;
							});
							gpmdp.addEventListener('playStateChanged', e => {
								if (this.gpmdpStates.playState !== 'stopped' || e.detail.playState !== 'paused') {
									this.gpmdpStates.playState = e.detail.playState;
								}
							});
							gpmdp.addEventListener('progressChanged', e => {
								this.gpmdpStates.progress = e.detail.progress;
							});
							gpmdp.addEventListener('trackChanged', e => {
								this.gpmdpStates.track = e.detail.track;
							});
						}

						if (type === 'playlist') {
							window.addEventListener('scroll', () => {
								const bottomReached = document.documentElement.scrollTop + window.innerHeight + 200 >= document.documentElement.offsetHeight;
								if (bottomReached && this.fetching === false && this.data.tracks.length !== this.data.total) {
									this.fetching = true;
									this.page++;
									axios
										.get(`${backend}/playlist/${this.page}`, {
											params: { id, userId }
										})
										.then(response => {
											this.data.tracks.push(...response.data.tracks);
											this.fetching = false;
										})
										.catch(e => console.log(e));
								}
							});
						}
						
						if (settings.service.url && type !== 'playlist') {
							window.location.href = LinkBuilder(data, type, settings.service.url);
						}
						else {
							this.loading = false;
							this.data = data;
						}						
					})
					.catch(err => {
						this.error = true;
					});
			});
	},
	methods: {
		play(track) {
			if (this.service.id === 'gpmdp') {
				GPMDP.play(track);
			}
			else {
				window.location.href = LinkBuilder(track, 'track', this.service.url)
			}
		},
		authenticate(pin) {
			GPMDP.authenticate(pin);
		}
	},
	components: { ...components, ...directorComponents, SetupGPMDP }
}
</script>

<style lang="scss">
body {
	background-image: url('../../img/concert.jpg');
}
</style>