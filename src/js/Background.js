import Settings from './Settings';
let settings = {};

Settings.subscribe(() => {
	Settings
		.get()
		.then(s => {
			settings = s;
		});
}, true);

chrome.webRequest.onBeforeRequest.addListener(details => {
	if (details.url.startsWith('https://open.spotify.com/')) {
		const originalUrl = details.url;

		const parser = document.createElement('a');
		parser.href = originalUrl;
		if (parser.hash == '#no-playify') {
			return;
		}

		const parts = parser.pathname.split('/');
		
		let type = parts[1];
		if (['album', 'artist', 'track', 'user'].indexOf(type) === -1) {
			return;
		}

		let id = parts[2];
		let userId = null;

		const playlistRegex = /\/user\/[^\/\\]+\/playlist\/[a-zA-Z0-9]+/ig;
		if (type === 'user') {
			if (!playlistRegex.test(parser.pathname)) {
				return;
			}
			type = 'playlist';
			id = parts[4];
			userId = parts[2];
		}

		if (type && id) {
			Settings.set({ director: { id, userId, type, originalUrl } });
			return {
				redirectUrl: chrome.extension.getURL('index.html')
			};
		}

	}
}, {
	urls: ['*://*.spotify.com/*'],
	types: ['main_frame']
}, ['blocking']);