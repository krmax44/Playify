<!--
https://codepen.io/krmax44/pen/mMXpoK

based on the pen of ArronYR
https://codepen.io/ArronYR/pen/vGXxwQ
-->

<template>
	<div class="eq-wrapper">
		<div :class="{ eq: true, playing }">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
</template>

<script>
export default {
	props: ['playing']
};
</script>

<style lang="scss" scoped>
.eq-wrapper {
	position: fixed;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	z-index: -1;
}

.eq {
	position: relative;
	height: 100vh;
}

.eq span {
	bottom: 0;
	position: absolute;
	background: rgba(255, 255, 255, 0.2);
	animation: eq 2s infinite ease;
	animation-play-state: paused;
}

.eq.playing span {
	animation-play-state: running;
}

@media (min-width: 600px) {
	@for $i from 0 through 10 {
		.eq span:nth-child(#{$i}) {
			width: 10vw;
			left: calc(10vw * #{$i} - 10vw);
			animation-delay: random(300) / 100 + s;
		}
	}
}

@media (max-width: 600px) {
	@for $i from 0 through 5 {
		.eq span:nth-child(#{$i}) {
			width: 20vw;
			left: calc(20vw * #{$i} - 20vw);
			animation-delay: random(300) / 100 + s;
		}
	}
	.eq span:nth-child(n + 6) {
		display: none;
	}
}

@keyframes eq {
	0% {
		height: 18vh;
	}
	10% {
		height: 27vh;
	}
	20% {
		height: 32vh;
	}
	40% {
		height: 23vh;
	}
	50% {
		height: 52vh;
	}
	60% {
		height: 16vh;
	}
	70% {
		height: 47vh;
	}
	100% {
		height: 9vh;
	}
}
</style>
