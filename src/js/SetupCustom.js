import Vue from 'vue';
import App from './Setup/SetupCustom.vue';
import '../style/main.scss';

new Vue({
	el: '#app',
	render: h => h(App)
});
