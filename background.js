chrome.webRequest.onBeforeRequest.addListener(
    function(details) {
        if (details.url.startsWith("https://open.spotify.com/")) {
            var parser = document.createElement("a");
            parser.href = details.url;

            if (parser.pathname.startsWith("/album/")) {
                var redirect = "https://krmax44.de/playify/?type=album&q=" + parser.pathname.split("/")[2];
                return { redirectUrl: redirect };
            } else if (parser.pathname.startsWith("/artist/")) {
                var redirect = "https://krmax44.de/playify/?type=artist&q=" + parser.pathname.split("/")[2];
                return { redirectUrl: redirect };
            } else if (parser.pathname.startsWith("/track/")) {
                var redirect = "https://krmax44.de/playify/?type=track&q=" + parser.pathname.split("/")[2];
                return { redirectUrl: redirect };
            }
        }
    }, {
        urls: ["*://*.spotify.com/*"],
        types: ["main_frame"]
    }, ["blocking"]
);
