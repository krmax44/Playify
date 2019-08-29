// see https://github.com/MarshallOfSound/Google-Play-Music-Desktop-Player-UNOFFICIAL-/blob/master/docs/PlaybackAPI_WebSocket.md

import Settings from './Settings';
import LinkBuilder from './LinkBuilder';

let connection = { readyState: 4 };
let connectionAttempts = 0;
let searches = [];

let settings = {};
Settings.get().then(s => {
	settings = s;
});

const codeRequired = new CustomEvent('codeRequired');
const authSuccess = new CustomEvent('authSuccess');
const authError = new CustomEvent('authError');
const connectionSuccess = new CustomEvent('connectionSuccess');
const connectionError = new CustomEvent('connectionError');

const send = (namespace, method, args) => {
	if (connection.readyState === 1) {
		if (!Array.isArray(args)) {
			args = [args];
		}
		connection.send(JSON.stringify({ namespace, method, arguments: args }));
	} else {
		connection.dispatchEvent(connectionError);
	}
};

export default {
	connect() {
		if (connection.readyState > 1) {
			connection = new WebSocket('ws://localhost:5672');
			connection.addEventListener('error', e => {
				console.log(e);
				connection.dispatchEvent(connectionError);
				connection.close();
			});
			connection.addEventListener('open', e => {
				const key = settings.service.extra.key;
				connection.dispatchEvent(connectionSuccess);
				send('connect', 'connect', key ? ['Playify', key] : 'Playify');
			});
			connection.addEventListener('close', e => {
				connection.dispatchEvent(connectionError);
			});
			connection.addEventListener('message', e => {
				try {
					const data = JSON.parse(e.data);
					const payload = data.payload;
					switch (data.channel) {
						case 'connect':
							if (payload === 'CODE_REQUIRED') {
								connection.dispatchEvent(
									connectionAttempts === 0 ? codeRequired : authError
								);
								connectionAttempts++;
							} else {
								Settings.set({
									service: {
										id: 'gpmdp',
										extra: {
											key: payload
										}
									}
								}).then(() => {
									settings.service.extra.key = payload;
									connectionAttempts = 0;
									send('connect', 'connect', ['Playify', payload]);
									connection.dispatchEvent(authSuccess);
								});
							}
							break;
						case 'search-results':
							if (searches.length > 0) {
								const { search, type } = searches[0];
								const item = payload[type][0];
								if (payload.searchText === search && item) {
									send('search', 'playResult', [item]);
								}
							}
							break;
						case 'playState':
							const playState = payload;
							const playStateChanged = new CustomEvent('playStateChanged', {
								detail: { playState: playState ? 'playing' : 'paused' }
							});
							connection.dispatchEvent(playStateChanged);
							break;
						case 'queue':
							if (payload.length === 0) {
								const playStateChanged = new CustomEvent('playStateChanged', {
									detail: { playState: 'stopped' }
								});
								connection.dispatchEvent(playStateChanged);
							}
							break;
						case 'track':
							const track = payload;
							const trackChanged = new CustomEvent('trackChanged', {
								detail: { track }
							});
							connection.dispatchEvent(trackChanged);
							break;
						case 'time':
							const progressChanged = new CustomEvent('progressChanged', {
								detail: { progress: payload }
							});
							connection.dispatchEvent(progressChanged);
							break;
					}
				} catch (e) {
					console.log(e); // handle malformatted JSON, etc.
				}
			});
		}
		return connection;
	},
	authenticate(pin) {
		send('connect', 'connect', ['Playify', pin]);
	},
	play(data, type) {
		type = type || 'track';
		const search = LinkBuilder(data, type);
		searches.unshift({ type: type + 's', search });
		send('search', 'performSearch', search);
	},
	playPause() {
		send('playback', 'playPause');
	},
	prev() {
		send('playback', 'rewind');
	},
	next() {
		send('playback', 'forward');
	},
	volume(volume) {
		send('volume', 'setVolume', volume);
	},
	progress(progress) {
		send('playback', 'setCurrentTime', progress);
	}
};
