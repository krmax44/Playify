<template>
	<Page title="Custom service" justifyContent="center">
		<h2>Please enter the URL of your service, replacing the search term with %q.</h2>
		<Grid justifyContent="center" alignItems="center">
			<Column width="*">
				<TextInput placeholder="https://example.com/search/%q" v-model="serviceUrl"></TextInput>
			</Column>
			<Column>
				<Button @click="save">Save</Button>
			</Column>
		</Grid>
		
		<h2>Examples:</h2>
		<Grid>
			<Column><Button @click="serviceUrl = 'https://music.amazon.com/search/%q'" dark="true" inline="true"><Icon icon="amazon" /> Amazon.com</Button></Column>
			<Column><Button @click="serviceUrl = 'https://music.amazon.de/search/%q'" dark="true" inline="true"><Icon icon="amazon" /> Amazon.de</Button></Column>
			<Column><Button @click="serviceUrl = 'https://music.amazon.co.uk/search/%q'" dark="true" inline="true"><Icon icon="amazon" /> Amazon.co.uk</Button></Column>
			<Column><Button @click="serviceUrl = 'https://www.deezer.com/search/'" dark="true" inline="true">Deezer</Button></Column>
		</Grid>
	</Page>
</template>

<script>
import Settings from '../Settings';
import components from '../Components';

export default {
	data() {
		return {
			serviceUrl: ''
		}
	},
	created() {
		Settings
			.get()
			.then(settings => {
				this.serviceUrl = settings.service.url || '';
			});
	},
	methods: {
		save() {
			let service = Settings.services.find(service => service.id === 'custom');
			service.url = this.serviceUrl;
			
			Settings
				.set({ service })
				.then(() => window.close());
		}
	},
	components
}
</script>

<style lang="scss">
body {
	background-image: url('../../img/concert-2.jpg');
}
</style>
