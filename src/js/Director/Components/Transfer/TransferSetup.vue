<template>
	<Modal :open="open" @close="$emit('close')">
		<h3>Please enter your credentials.</h3>

		<p>Need help? Check out the <LinkLabel href="https://github.com/krmax44/Playify-Transfer/blob/master/README.md#playify-transfer" target="_blank">Playify Transfer docs</LinkLabel>.</p>

		<TextInput type="password" placeholder="Transfer password" dark="true" v-model="auth" :error="error" />
		<TextInput placeholder="Google email" dark="true"  v-model="email" :error="googleError" />
		<TextInput type="password" placeholder="Google password" dark="true"  v-model="password" :error="googleError" />
		<Button @click="save">Login</Button>
	</Modal>
</template>

<script>
import Settings from '../../../Settings';
import { Button, Modal, TextInput, Grid, Column, LinkLabel } from '../../../Components';

export default {
	props: ['open', 'error', 'googleError'],
	data() {
		return {
			auth: '',
			email: '',
			password: ''
		}
	},
	methods: {
		save() {
			const { auth, email, password } = this;
			this.$emit('save', { auth, email, password });
		}
	},
	components: { Button, Modal, TextInput, Grid, Column, LinkLabel }
}
</script>