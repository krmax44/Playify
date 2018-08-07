const services = [
	{
		id: 'gpm',
		name: 'Google Play Music',
		url: 'https://play.google.com/music/listen#/sr/%q',
		extra: {}
	},
	{
		id: 'gpmdp',
		name: 'Google Play Music Desktop Player',
		url: null,
		extra: {
			key: ''
		}
	},
	{
		id: 'yt',
		name: 'YouTube',
		url: 'https://www.youtube.com/results?search_query=%q',
		extra: {}
	},
	{
		id: 'ytm',
		name: 'YouTube Music',
		url: 'https://music.youtube.com/search?q=%q',
		extra: {}
	},
	{
		id: 'custom',
		name: 'More...',
		url: 'https://duckduckgo.com/?q=%q',
		extra: {}
	}
];

const defaultSettings = {
	service: services[0],
	director: {
		id: '',
		userId: '',
		type: ''
	}
};

const get = () => new Promise(resolve => {
	chrome.storage.local.get(defaultSettings, data => resolve(data));
});

const set = (settings) => new Promise(resolve => {
	chrome.storage.local.set(settings, () => resolve());
});

const subscribe = (fn, exec) => {
	chrome.storage.onChanged.addListener(fn);
	if (exec) {
		fn();
	}
};

module.exports = { get, set, subscribe, defaultSettings, services };