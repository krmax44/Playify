<template>
	<div>
		<div v-for="service in services" :key="service.id" class="input-field">
			<input
				type="radio"
				:name="name"
				:id="service.id"
				:value="service.id"
				:checked="service.active"
				@change="change"
			/>
			<label :for="service.id">{{ service.name }}</label>
			<transition name="fade">
				<LinkLabel
					v-if="service.id === 'custom' && service.active"
					constant="true"
					@click="setup(service.id)"
					>Setup</LinkLabel
				>
			</transition>
		</div>
	</div>
</template>

<script>
import { LinkLabel } from '../../Components';

export default {
	props: ['services'],
	data() {
		return {
			name: Math.random()
				.toString(36)
				.substring(2)
		};
	},
	methods: {
		change(e) {
			this.$emit('serviceChanged', e.srcElement.value);
		},
		setup(service) {
			window.open(service + '.html', '_blank');
		}
	},
	components: { LinkLabel }
};
</script>

<style lang="scss" scoped>
@import '../../../style/variables.scss';

.input-field {
	display: flex;
	align-items: left;
	justify-content: left;

	input[type='radio'] {
		display: none;

		& + label {
			position: relative;
			left: 30px;
			margin-bottom: 5px;
			color: $light;
			transition: 0.3s;

			&::after,
			&::before {
				display: inline-block;
				position: absolute;
				left: -30px;
				padding: 7px;
				content: ' ';
				border-radius: 50%;
				border: 2px $light solid;
				transition: 0.3s;
			}

			&::before {
				border-color: transparent;
				transform: scale(0);
				background-color: $green;
			}
		}

		&:checked + label {
			color: $green;

			&::before {
				transform: scale(1);
			}

			&::after {
				border-color: $green;
			}
		}
	}

	a.link {
		position: relative;
		left: 35px;
	}
}
</style>
