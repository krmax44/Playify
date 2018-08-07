<template>
	<Modal :open="open" @close="$emit('close')">
		<h3>Transfering your playlist...</h3>

		<Grid v-for="item in progress" :key="item.track" class="progress-item">
			<Column>
				<Icon :icon="item.error ? 'cross' : 'check'" black="true" />
			</Column>
			<Column>
				{{ item.track }}
			</Column>
		</Grid>
	</Modal>
</template>

<script>
import Settings from '../../../Settings';
import { Button, Modal, Grid, Column, TextInput, Selector, Icon } from '../../../Components';

export default {
	props: ['open', 'progress'],
	data() {
		return {
			playlist: 'new',
			newPlaylist: ''
		}
	},
	methods: {
		close() {
			this.$emit('close');
		}
	},
	components: { Button, Modal, Grid, Column, TextInput, Selector, Icon }
}
</script>

<style lang="scss" scoped>
@import '../../../../style/variables.scss';

.modal .modal-inner {
	height: 100% !important;
}

.progress-item {
	padding: 5px 0;
	border-bottom: 2px $green solid;

	&:last-child {
		border-bottom: none;
	}
}
</style>