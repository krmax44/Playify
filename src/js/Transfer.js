// interface for https://github.com/krmax44/Playify-Transfer

let connection = { readyState: 4 };

const connectionSuccess = new CustomEvent('connectionSuccess');
const connectionError = new CustomEvent('connectionError');

const send = data => {
	if (connection.readyState === 1) {
		connection.send(JSON.stringify(data));
	} else {
		connection.dispatchEvent(connectionError);
	}
};

module.exports = {
	connect() {
		if (connection.readyState > 1) {
			connection = new WebSocket('ws://localhost:5673');
			connection.addEventListener('error', () => {
				connection.dispatchEvent(connectionError);
				connection.close();
			});
			connection.addEventListener('open', e => {
				connection.dispatchEvent(connectionSuccess);
			});
			connection.addEventListener('message', e => {
				try {
					const data = JSON.parse(e.data);

					switch (data.q) {
						case 'playlists':
							const playlists = data.lists;
							const receivedPlaylists = new CustomEvent('receivedPlaylists', {
								detail: { playlists }
							});
							connection.dispatchEvent(receivedPlaylists);
							break;
						case 'progress':
							const { track, error } = data;
							const madeProgress = new CustomEvent('madeProgress', {
								detail: { track, error }
							});
							connection.dispatchEvent(madeProgress);
							break;
						case 'auth':
							const google = data.google || false;
							const authEvent = new CustomEvent(
								data.error ? 'authError' : 'authSuccess',
								{ detail: { google } }
							);
							connection.dispatchEvent(authEvent);
							break;
					}
				} catch (e) {
					console.log(e); // handle malformatted JSON, etc.
				}
			});
		}
		return connection;
	},
	authenticate(auth) {
		send({
			q: 'auth',
			...auth
		});
	},
	getPlaylists(auth) {
		send({
			q: 'get_playlists',
			...auth
		});
	},
	transferPlaylist(auth, tracks, playlist, newPlaylist) {
		send({
			q: 'transfer_playlist',
			...auth,
			tracks,
			playlist,
			new_playlist: newPlaylist
		});
	}
};
