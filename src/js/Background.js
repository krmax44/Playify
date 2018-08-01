import Settings from './Settings';
let settings = {};

const retrieveSettings = () => {
	Settings
		.get()
		.then(s => {
			settings = s;
		});
};

retrieveSettings();
chrome.storage.onChanged.addListener(retrieveSettings);

chrome.webRequest.onBeforeRequest.addListener(details => {
	if (details.url.startsWith('https://open.spotify.com/')) {
		let parser = document.createElement('a');
		parser.href = details.url;

		if (parser.hash == '#no-playify') {
			return;
		}

		const parts = parser.pathname.split('/');
		console.log(parts);
		
		let id, userId, type;
		id = parts[2];
		type = parts[1];

		if (['album', 'artist', 'track', 'user'].indexOf(type) === -1) {
			return;
		}

		const playlistRegex = /\/user\/[^\/\\]+\/playlist\/[a-zA-Z0-9]+/ig; // only user playlists
		if (type === 'user') {
			if (!playlistRegex.test(parser.pathname)) {
				return;
			}
			type = 'playlist';
			id = parts[4];
			userId = parts[2];
		}

		if (type && id) {
			Settings.set({ director: { id, userId, type	} });
			return {
				redirectUrl: `chrome-extension://${chrome.app.getDetails().id}/index.html`
			};
		}

	}
}, {
	urls: ['*://*.spotify.com/*'],
	types: ['main_frame']
}, ['blocking']);