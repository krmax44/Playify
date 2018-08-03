<template>
	<div class="input-field" :class="{ focus, dark, error }">
		<input
			type="text"
			:value="value"
			:placeholder="placeholder"
			autocomplete="off"
			@focus="inputEvent"
			@focusout="inputEvent"
			@keyup="inputEvent"
			@input="valueEvent">
	</div>
</template>

<script>
export default {
	props: ['value', 'placeholder', 'dark', 'error'],
	data() {
		return {
			focus: false,
			text: ''
		}
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
			if ((e.type == 'focus' || e.type == 'keyup') && e.target.value.length > 0) {
				this.focus = true;
			}
			else {
				this.focus = false;
			}
		}
	}
}
</script>

<style lang="scss" scoped>
@import '../../style/variables.scss';

.input-field {
	position: relative;
	padding: 5px 0;

	&::before, &::after {
		content: ' ';
		position: absolute;
		bottom: 0;
		border-bottom: 2px $light solid;
		transition: .3s;
	}

	&::after {
		left: 50%;
		right: 50%;
		border-bottom: 2px $green solid;
	}

	&::before, &.focus::after {
		left: 0;
		right: 0;
	}

	input[type='text'] {
		border: 0;
		background-color: transparent;
		font-family: $font-stack;
		font-size: 1em;
		width: 100%;
		color: $light;

		::placeholder {
			color: rgba(255,255,255,.5);
		}
	}

	&.dark {
		&::before {
			border-bottom-color: $dark;
		}

		input[type='text'] {
			color: $dark;

			::placeholder {
				color: rgba(0,0,0,.5);
			}
		}
	}

	&.error {
		&::before, &::after {
			border-bottom-color: $red;
		}
	}
}
</style>