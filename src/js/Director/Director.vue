<template>
	<Page title="Playify" :justifyContent="alignment" :alignItems="alignment">
		<Loading v-if="loading" />
		<Error v-if="error" :director="director" />

		<Player v-if="!loading && !error" :data="data" :director="director" :service="service" @play="play" />

		<div v-if="service.id === 'gpmdp'">
			<GPMDPController :data="gpmdpStates" />
			<GPMDPSetup :open="gpmdpSetup.open" :fail="gpmdpSetup.failed" @save="authenticate" />
			<EQ :playing="gpmdpStates.playState === 'playing'" />
			<Notification :visible="gpmdpStates.error">
				<Grid>
					<Column width="*">Can't connect to GPMDP.</Column>
					<Column>
						<Button inline="true" href="https://github.com/krmax44/Playify/blob/master/README.md#GPMDP" target="_blank">Help</Button>
						<Button inline="true" @click="gpmdpConnect">Try again</Button>
					</Column>
				</Grid>
			</Notification>
		</div>
	</Page>
</template>

<script>
import Settings from '../Settings';
import components from '../Components';
import directorComponents from './Components';
import LinkBuilder from '../LinkBuilder';
import GPMDP from '../GPMDP';
import axios from 'axios';
const backend = 'http://localhost:3000';

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
				progress: null,
				connected: false,
				error: false
			}
		}
	},
	computed: {
		alignment() {
			return this.loading || this.error ? 'center' : '';
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

				const parser = document.createElement('a');
				parser.href = window.location.href;
				try {
					const data = JSON.parse(decodeURIComponent(parser.hash.substr(1)));
					if (data.id && data.type) {
						this.director = data;
					}
				}
				catch (e) {
					console.log('No data in hash.');
				}

				this.requestData();
			});
	},
	methods: {
		requestData() {
			const { id, userId, type } = this.director;

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

					this.data = data;

					if (this.service.id === 'gpmdp') {
						this.gpmdpConnect();
					}
					
					if (type !== 'playlist') {
						if (this.service.id !== 'gpmdp') {
							window.location.href = LinkBuilder(data, type, this.service.url);
						}
					}
					else {
						window.addEventListener('scroll', () => this.endlessScroll);
					}
					
					this.loading = false;
				})
				.catch(err => {
					console.log(err);
					this.loading = false;
					this.error = true;
				});
		},
		play(data) {
			const type = data.type || 'track';
			if (this.service.id === 'gpmdp') {
				GPMDP.play(data, type);
			}
			else {
				window.open(LinkBuilder(data, 'track', this.service.url), '_blank');
			}
		},
		authenticate(pin) {
			GPMDP.authenticate(pin);
		},
		gpmdpConnect() {
			if (this.gpmdpStates.connected === false) {
				const gpmdp = GPMDP.connect();
				this.gpmdpStates.connected = true;
				gpmdp.addEventListener('connectionSuccess', () => {
					this.gpmdpStates.connected = true;
					this.gpmdpStates.error = false;
				});
				gpmdp.addEventListener('connectionError', () => {
					this.gpmdpStates.connected = false;
					this.gpmdpStates.error = true;
				});
				gpmdp.addEventListener('codeRequired', () => {
					this.gpmdpSetup.open = true;
				});
				gpmdp.addEventListener('authFail', () => {
					console.log('authfail');
					this.gpmdpSetup.open = true;
					this.gpmdpSetup.failed = true;
				});
				gpmdp.addEventListener('authSuccess', () => {
					this.gpmdpSetup.open = false;
					this.gpmdpSetup.failed = false;
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
		},
		endlessScroll() {
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
		}
	},
	components: { ...components, ...directorComponents }
}
</script>

<style lang="scss">
body {
	background-image: url('../../img/concert.jpg');
}
</style>