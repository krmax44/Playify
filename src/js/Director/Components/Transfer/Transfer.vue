<template>
	<div>
		<TransferSetup
			:open="setup.open"
			:error="setup.error"
			:googleError="setup.googleError"
			@save="authenticate"
			@close="setup.open = false"
		/>
		<TransferPicker
			:open="picker.open"
			:playlists="picker.playlists"
			:fetching="fetching"
			@save="transfer"
			@close="picker.open = false"
		/>
		<TransferProgress
			:open="progress.open"
			:progress="progress.progress"
			@close="progress.open = false"
		/>

		<Notification :visible="error">
			<Grid>
				<Column width="*">Can't connect to Transfer.</Column>
				<Column>
					<Button
						inline="true"
						href="https://github.com/krmax44/Playify-Transfer/blob/master/README.md#playify-transfer"
						target="_blank"
						>Help</Button
					>
					<Button inline="true" @click="connect">Try again</Button>
					<Button inline="true" @click="error = false">Close</Button>
				</Column>
			</Grid>
		</Notification>
	</div>
</template>

<script>
import TransferSetup from './TransferSetup.vue';
import TransferPicker from './TransferPicker.vue';
import TransferProgress from './TransferProgress.vue';
import { Grid, Column, Button, Notification } from '../../../Components';
import Transfer from '../../../Transfer';

export default {
	props: ['data', 'fetching'],
	data() {
		return {
			connected: false,
			error: false,
			picker: {
				open: false,
				playlists: []
			},
			progress: {
				open: false,
				progress: []
			},
			setup: {
				open: false,
				error: false,
				googleError: false
			},
			auth: {
				auth: null,
				email: null,
				password: null
			},
			connection: { readyState: 3 }
		};
	},
	methods: {
		connect() {
			if (this.connection.readyState > 1) {
				this.connection = Transfer.connect();
				this.connection.addEventListener('connectionSuccess', () => {
					this.connected = true;
					this.error = false;
					this.setup.open = true;
				});
				this.connection.addEventListener('connectionError', () => {
					this.connected = false;
					this.error = true;
				});
				this.connection.addEventListener('authSuccess', () => {
					Transfer.getPlaylists(this.auth);
					this.setup.open = false;
					this.setup.error = false;
					this.setup.googleError = false;
				});
				this.connection.addEventListener('authError', e => {
					this.setup.open = true;
					this.setup.error = true;
					this.setup.googleError = e.detail.google;
				});
				this.connection.addEventListener('receivedPlaylists', e => {
					this.picker.playlists = e.detail.playlists;
					this.picker.open = true;
				});
				this.connection.addEventListener('madeProgress', e => {
					this.progress.progress.unshift(e.detail);
				});
			} else if (this.auth.auth === null) {
				this.setup.open = true;
			} else if (this.progress.progress.length === 0) {
				this.picker.open = true;
			}
		},
		authenticate(auth) {
			this.auth = auth;
			Transfer.authenticate(auth);
		},
		transfer(data) {
			this.picker.open = false;
			this.progress.open = true;
			const { playlist, newPlaylist } = data;
			const tracks = this.data.tracks.map(
				track => `${track.name} - ${track.artists[0]}`
			);
			Transfer.transferPlaylist(this.auth, tracks, playlist, newPlaylist);
		}
	},
	components: {
		TransferSetup,
		TransferPicker,
		TransferProgress,
		Grid,
		Column,
		Button,
		Notification
	}
};
</script>

<style lang="scss" scoped>
.notification {
	z-index: 100;
}
</style>
