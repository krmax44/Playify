<template>
	<Page title="Playify" :justifyContent="alignment" :alignItems="alignment">
		<Loading v-if="loading" />
		<Error v-if="error" :director="director" />

		<Player
			v-if="!loading && !error"
			:data="data"
			:director="director"
			:service="service"
			@play="play"
			@transfer="startTransfer"
		/>

		<GPMDP v-if="service.id === 'gpmdp'" />
		<Transfer
			v-if="director.type === 'playlist'"
			:data="data"
			:fetching="fetching"
			ref="transfer"
		/>
	</Page>
</template>

<script>
import Settings from '../Settings';
import * as components from '../Components';
import * as directorComponents from './Components';
import LinkBuilder from '../LinkBuilder';
import GPMDP from '../GPMDP';
import axios from 'axios';
const backend = 'https://playify.krmax44.de'; // https://github.com/krmax44/Playify-Backend

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
			}
		};
	},
	computed: {
		alignment() {
			return this.loading || this.error ? 'center' : '';
		}
	},
	created() {
		Settings.subscribe(settings => {
			Settings.get().then(settings => {
				this.service = settings.service;
			});
		}, true);

		Settings.get().then(settings => {
			this.service = settings.service;

			try {
				const data = JSON.parse(decodeURIComponent(window.location.hash.substr(1)));
				if (data.id && data.type && data.originalUrl) {
					this.director = data;
				}
			} catch (e) {
				console.log('No data in hash.');
			}

			window.location.hash = '';

			this.requestData();
		});
	},
	methods: {
		requestData() {
			const { id, type } = this.director;
			console.log(this.director, id, type);
			setTimeout(() => Settings.get().then(settings => console.info), 10);
			axios
				.get(`${backend}/${type}`, {
					params: { id }
				})
				.then(response => {
					this.fetching = false;
					const data = response.data;

					if (data.error === true) {
						return Promise.reject(data.errorMsg);
					}

					this.data = data;

					if (type === 'playlist') {
						window.addEventListener('scroll', this.endlessScroll);
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
			} else {
				window.open(LinkBuilder(data, 'track', this.service.url), '_blank');
			}
		},
		startTransfer() {
			this.$refs.transfer.connect();
			this.fetching = true;
			const getAllTracks = () => {
				this.page++;
				const { id } = this.director;
				axios
					.get(`${backend}/playlist/${this.page}`, {
						params: { id }
					})
					.then(response => {
						if (response.data.tracks) {
							this.data.tracks.push(...response.data.tracks);
							if (this.data.tracks.length < this.data.total) {
								return getAllTracks();
							}
						}
						this.fetching = false;
					})
					.catch(e => console.log(e));
			};
			getAllTracks();
		},
		endlessScroll() {
			const bottomReached =
				document.documentElement.scrollTop + window.innerHeight + 200 >=
				document.documentElement.offsetHeight;
			if (
				bottomReached &&
				this.fetching === false &&
				this.data.tracks.length < this.data.total
			) {
				this.fetching = true;
				this.page++;
				const { id } = this.director;
				axios
					.get(`${backend}/playlist/${this.page}`, {
						params: { id }
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
};
</script>

<style lang="scss">
body {
	background-image: url('../../img/concert.jpg');
}
</style>
