function getSettings () {
	chrome.storage.local.get({
		service: {
			name: "gpm",
			extra: ".com"
		}
	}, function (items){
		$(".settings-item.service input[type=radio]").each(function(){
			if ($(this).val() == items.service.name) {
				$(this).prop("checked", true);
			} else {
				$(this).prop("checked", false);
			}
		});
		$(".settings-item.service select").val(items.service.extra);
	});
}

function setSettings () {
	chrome.storage.local.set({
		service: {
			name: $(".settings-item.service input[type=radio]:checked").val(),
			extra: $(".settings-item.service select").val()
		}
	});
}

$("input").on("change", setSettings);
$("select").on("change", setSettings);

$("#region-select").on("click", function(){
	$("#amazon-region").slideDown();
});

$("#region-back").on("click", function(){
	$("#amazon-region").slideUp();
});

$("#setup-gpmdp").on("click", function(){
	$("#gpmdp-setup").slideDown();
	$(".step.error").hide();
	$(".step.finished").hide();
	$(".step.enter-code").show();
	setupgpmdp();
});

$(".gpmdp-back").on("click", function(){
	$("#gpmdp-setup").slideUp();
});

document.addEventListener("DOMContentLoaded", getSettings);