<template>
	<Modal :open="open">
		<h3>Please enter the code you see in GPMDP.</h3>
		<p>Make sure you have activated the Playback API.</p>

		<Form @submit="save">
			<Grid justifyContent="center" alignItems="center">
				<Column width="*">
					<TextInput dark="true" v-model="code" placeholder="1234" /> 
				</Column>
				<Column>
					<Button @click="save">Save</Button>
				</Column>
			</Grid>
		</Form>
	</Modal>
</template>

<script>
import Settings from '../Settings';
import { Button, Modal, TextInput, Grid, Column } from '../Components';

export default {
	props: ['open'],
	data() {
		return {
			code: ''
		}
	},
	methods: {
		save() {
			this.$emit('save', this.code);
		}
	},
	components: { Button, Modal, TextInput, Grid, Column }
}
</script>

<style lang="scss" scoped>

</style>