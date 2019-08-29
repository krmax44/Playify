<template>
	<InputWrapper :classes="{ focus, dark, error }">
		<select
			autocomplete="off"
			@focus="inputEvent"
			@focusout="inputEvent"
			@input="valueEvent"
			:class="{ dark }"
			v-model="value"
		>
			<option
				v-for="option in options"
				:key="option.value"
				:value="option.value"
			>
				{{ option.text }}
			</option>
		</select>
	</InputWrapper>
</template>

<script>
import InputWrapper from './InputWrapper.vue';

export default {
	props: ['options', 'dark', 'error'],
	data() {
		return {
			focus: false,
			value: this.options.find(option => option.selected).value
		};
	},
	methods: {
		valueEvent(e) {
			this.value = e.target.value;
			this.$emit('input', e.target.value);
		},
		inputEvent(e) {
			if (e.type === 'focus') {
				this.focus = true;
			} else {
				this.focus = false;
			}
		}
	},
	components: { InputWrapper }
};
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

select {
	margin-top: 5px;
	border: 0;
	border-bottom: 5px solid transparent;
	background-color: transparent;
	font-family: $font-stack;
	font-size: 1em;
	width: 100%;
	color: $light;

	option {
		background-color: $light;
		color: $dark;

		&:checked {
			background-color: $green;
			color: $light;
		}
	}

	&.dark {
		color: $dark;
	}
}
</style>
