<template>
	<Modal :open="open" @close="$emit('close')">
		<h3>Please enter the code you see in GPMDP.</h3>

		<Grid justifyContent="center" alignItems="center">
			<Column width="*">
				<TextInput :error="error" dark="true" :value="code" @input="input" placeholder="1234" /> 
			</Column>
			<Column>
				<Button @click="save">Connect</Button>
			</Column>
		</Grid>
	</Modal>
</template>

<script>
import Settings from '../../../Settings';
import { Button, Modal, TextInput, Grid, Column } from '../../../Components';

export default {
	props: ['open', 'error'],
	data() {
		return {
			code: ''
		}
	},
	methods: {
		save() {
			this.$emit('save', this.code);
		},
		input(value) {
			this.code = value;
			if (value.length === 4) {
				this.save();
			}
		}
	},
	components: { Button, Modal, TextInput, Grid, Column }
}
</script>