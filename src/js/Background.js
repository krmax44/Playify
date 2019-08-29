chrome.webRequest.onBeforeRequest.addListener(
	details => {
		if (details.url.startsWith('https://open.spotify.com/')) {
			const originalUrl = details.url;
			const url = new URL(originalUrl);
			if (url.hash === '#no-playify') {
				return;
			}

			const regex = /^\/(user\/[^/\\]*\/)?(playlist|artist|track|album)\/([a-zA-Z0-9]+)$/; // see https://regex101.com/r/A01hDI/1
			const results = url.pathname.match(regex);

			if (results) {
				const [type, id] = results.slice(2);

				const redirect = new URL(chrome.extension.getURL('index.html'));
				redirect.hash = `#${encodeURIComponent(
					JSON.stringify({ type, id, originalUrl })
				)}`;

				return {
					redirectUrl: redirect.href
				};
			}
		}
	},
	{
		urls: ['*://*.spotify.com/*'],
		types: ['main_frame']
	},
	['blocking']
);
