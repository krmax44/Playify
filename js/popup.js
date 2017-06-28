function getSettings () {
	chrome.storage.sync.get({
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
	chrome.storage.sync.set({
		service: {
			name: $(".settings-item.service input[type=radio]:checked").val(),
			extra: $(".settings-item.service select").val()
		}
	});
}

$("input").on("change", setSettings);
$("select").on("change", setSettings);

document.addEventListener("DOMContentLoaded", getSettings);