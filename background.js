chrome.webRequest.onBeforeRequest.addListener(
    function(details) {
        if (details.url.startsWith("https://open.spotify.com/")) {
            const parser = document.createElement("a");
            parser.href = details.url;

            const redirectBase = 'https://krmax44.de/playify/';

            const requestExplode = parser.pathname.split("/");
            const requestType = requestExplode[1];
            const requestId = requestExplode[2];

            if (!!requestType) {
              return { redirectUrl: `${redirectBase}?type=${requestType}&q=${requestId}` };
            }
        }
    }, {
        urls: ["*://*.spotify.com/*"],
        types: ["main_frame"]
    }, ["blocking"]
);
