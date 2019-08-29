const concat = (a, b) => {
	return `${a} - ${b}`;
};

const handler = {
	album: album => concat(album.name, album.artists[0]),
	artist: artist => artist.name,
	track: track => concat(track.name, track.artists[0])
};

const builder = (data, type, url) => {
	const search = handler[type || 'track'](data);
	return url ? url.replace('%q', encodeURIComponent(search)) : search;
};

export default builder;
