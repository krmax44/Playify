<template>
	<div>
		<GPMDPController
			:track="track"
			:progress="progress"
			:playState="playState"
		/>
		<GPMDPSetup
			:open="setup.open"
			:error="setup.error"
			@save="authenticate"
			@close="setup.open = false"
		/>

		<EQ :playing="playState === 'playing'" />

		<Notification :visible="error">
			<Grid>
				<Column width="*">Can't connect to GPMDP.</Column>
				<Column>
					<Button
						inline="true"
						href="https://github.com/krmax44/Playify/blob/master/README.md#GPMDP"
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
import GPMDPController from './GPMDPController.vue';
import GPMDPSetup from './GPMDPSetup.vue';
import { Grid, Column, Button, Notification } from '../../../Components';
import EQ from '../EQ.vue';
import GPMDP from '../../../GPMDP';

export default {
	data() {
		return {
			track: null,
			playState: null,
			progress: null,
			connected: false,
			error: false,
			setup: {
				open: false,
				error: false
			}
		};
	},
	methods: {
		connect() {
			if (this.connected === false) {
				const gpmdp = GPMDP.connect();
				this.connected = true;
				gpmdp.addEventListener('connectionSuccess', () => {
					this.connected = true;
					this.error = false;
				});
				gpmdp.addEventListener('connectionError', () => {
					this.connected = false;
					this.error = true;
				});
				gpmdp.addEventListener('codeRequired', () => {
					this.setup.open = true;
				});
				gpmdp.addEventListener('authError', () => {
					this.setup.open = true;
					this.setup.error = true;
				});
				gpmdp.addEventListener('authSuccess', () => {
					this.setup.open = false;
					this.setup.error = false;
				});
				gpmdp.addEventListener('playStateChanged', e => {
					if (this.playState !== 'stopped' || e.detail.playState !== 'paused') {
						this.playState = e.detail.playState;
					}
				});
				gpmdp.addEventListener('progressChanged', e => {
					this.progress = e.detail.progress;
				});
				gpmdp.addEventListener('trackChanged', e => {
					this.track = e.detail.track;
				});
			}
		},
		authenticate(pin) {
			GPMDP.authenticate(pin);
		}
	},
	created() {
		this.connect();
	},
	components: {
		GPMDPController,
		GPMDPSetup,
		Grid,
		Column,
		Button,
		Notification,
		EQ
	}
};
</script>
