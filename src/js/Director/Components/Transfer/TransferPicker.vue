<template>
	<Modal :open="open" @close="$emit('close')">
		<h3>Please select the target playlist or create a new one.</h3>

		<Selector :options="options" v-model="playlist" dark="true" />
		<TextInput placeholder="Playlist name" dark="true" v-model="newPlaylist" v-if="playlist === 'new'" />
		<Button @click="save">{{ fetching ? 'Please wait...' : 'Transfer' }}</Button>
	</Modal>
</template>

<script>
import Settings from '../../../Settings';
import { Button, Modal, TextInput, Grid, Column, Selector } from '../../../Components';

export default {
	props: ['open', 'playlists', 'fetching'],
	data() {
		return {
			playlist: 'new',
			newPlaylist: ''
		}
	},
	computed: {
		options() {
			const options = this.playlists.map(playlist => Object.assign({}, {
				value: playlist.id,
				text: playlist.name
			}));
			options.unshift({
				value: 'new',
				text: 'Create new playlist...',
				selected: true
			});
			return options;
		}
	},
	methods: {
		save() {
			if (!this.fetching) {
				const newPlaylist = this.playlist === 'new';
				this.$emit('save', {
					playlist: newPlaylist ? this.newPlaylist : this.playlist,
					newPlaylist
				});
			}
		}
	},
	components: { Button, Modal, Grid, Column, TextInput, Selector }
}
</script>