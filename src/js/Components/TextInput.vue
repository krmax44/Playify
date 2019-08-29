<template>
	<InputWrapper :class="{ focus, dark, error }">
		<input
			:type="type || 'text'"
			:value="value"
			:placeholder="placeholder"
			:class="{ dark }"
			autocomplete="nope"
			@focus="inputEvent"
			@focusout="inputEvent"
			@keyup="inputEvent"
			@input="valueEvent"
		/>
	</InputWrapper>
</template>

<script>
import InputWrapper from './InputWrapper.vue';

export default {
	props: ['type', 'value', 'placeholder', 'dark', 'error'],
	data() {
		return {
			focus: false,
			text: ''
		};
	},
	created() {
		this.text = this.value || '';
	},
	updated() {
		this.text = this.value || '';
	},
	methods: {
		valueEvent(e) {
			this.text = e.target.value;
			this.$emit('input', e.target.value);
		},
		inputEvent(e) {
			if (
				(e.type === 'focus' || e.type === 'keyup') &&
				e.target.value.length > 0
			) {
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

input {
	margin: 5px 0;
	border: 0;
	background-color: transparent;
	font-family: $font-stack;
	font-size: 1em;
	width: 100%;
	color: $light;

	::placeholder {
		color: rgba(255, 255, 255, 0.5);
	}

	&.dark {
		color: $dark;

		::placeholder {
			color: rgba(0, 0, 0, 0.5);
		}
	}
}
</style>
