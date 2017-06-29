var socket = new WebSocket("ws://localhost:5672");
var codeRequested = false;
var sendingLogin = "";

socket.onmessage = function (message) {
	var data = JSON.parse(message.data);
	
	if (data.channel == "connect") {
		if (data.payload == "CODE_REQUIRED" && codeRequested == true) {
			$(".step").hide();
			$(".step.enter-code").show().children("p").text("Wrong code. Please try again.").css("color", "red");
			$("#code").val("").focus();
		}
		if (data.payload == "CODE_REQUIRED" && codeRequested == false) {
			$(".step").hide();
			$(".step.enter-code").show();
			$("#code").focus();
			codeRequested = true;
		} 
		if (data.payload != "CODE_REQUIRED") {
			$(".step").hide();
			$(".step.finished").show();
			socket.send(JSON.stringify({
				namespace: "connect",
				method: "connect",
				arguments: ["Playify", data.payload]
			}));
			chrome.storage.sync.set({
				gpmdp: {
					key: data.payload
				}
			});
		}
	}
};

socket.onopen = function() {
	socket.send(JSON.stringify({
		namespace: "connect",
		method: "connect",
		arguments: ["Playify"]
	}));
};

socket.onerror = function() {
	$(".step").hide();
	$(".step.error").show();
};

$("#code").on("keyup", function(){
	if (/^[0-9]{4}/.test($(this).val()) && sendingLogin != $(this).val()) {
		sendingLogin = $(this).val();
		socket.send(JSON.stringify({
			namespace: "connect",
			method: "connect",
			arguments: ["Playify", $(this).val()]
		}));
	}
});