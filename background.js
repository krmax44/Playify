chrome.webRequest.onBeforeRequest.addListener(
    function(details) {
        if (details.url.startsWith("https://open.spotify.com/")) {
            var parser = document.createElement("a");
            parser.href = details.url;

            var requestBase = 'https://krmax44.de/playify/?type=';
            var requestId = parser.pathname.split("/")[2];
            var requestType = '';

            if (parser.pathname.startsWith("/album/")) {
                requestType = "album";
            } else if (parser.pathname.startsWith("/artist/")) {
                requestType = "artist";
            } else if (parser.pathname.startsWith("/track/")) {
                requestType = "track";
            }

            if (!!requestType) {
              return { redirectUrl: requestBase + requestType + "&q=" + requestId };
            }

        }
    }, {
        urls: ["*://*.spotify.com/*"],
        types: ["main_frame"]
    }, ["blocking"]
);
