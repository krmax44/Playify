<template>
	<Modal :open="open">
		<h3>Please enter the code you see in GPMDP.</h3>

		<Form @submit="save">
			<Grid justifyContent="center" alignItems="center">
				<Column width="*">
					<TextInput :error="fail" dark="true" :value="code" @input="input" placeholder="1234" /> 
				</Column>
				<Column>
					<Button @click="save">Save</Button>
				</Column>
			</Grid>
		</Form>
	</Modal>
</template>

<script>
import Settings from '../../../Settings';
import { Button, Modal, TextInput, Grid, Column } from '../../../Components';

export default {
	props: ['open', 'fail'],
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

<style lang="scss" scoped>
.modal-inner {
	max-width: 500px;
}
</style>
