$(function() {
	$(".cbox").on("click", function(event) {
		event.stopPropagation();
	});
	$(".select-item").on("click", function() {
		var status = $(this).prop("checked");
		var group = $(this).parent().parent().parent().parent().parent();
		if (status == false) {
			group.prev().find(".select-group").removeProp("checked");
			$("#select-all").removeProp("checked");
		} else {
			var flag = true;
			group.find(".select-item").each(function() {
				flag = flag & $(this).prop("checked");
			});
			if (flag == true) {
				group.prev().find(".select-group").prop("checked", "checked");
				$(".select-group").each(function() {
					flag = flag & $(this).prop("checked");
				});
				if (flag == true) {
					$("#select-all").prop("checked", "checked");
				} else {
					$("#select-all").removeProp("checked");
				}
			}
		}
	});
	$(".select-group").on("click", function() {
		var status = $(this).prop("checked");
		var div = $(this).parent().parent().parent().next().find(".select-item");
		if (status == false) {
			div.removeProp("checked");
			$("#select-all").removeProp("checked");
		} else {
			div.prop("checked", "checked");
			var flag = true;
			$(".select-group").each(function() {
				flag = flag & $(this).prop("checked");
			});
			if (flag == true) {
				$("#select-all").prop("checked", "checked");
			} else {
				$("#select-all").removeProp("checked");
			}
		}
	});
	$("#select-all").on("click", function() {
		var status = $(this).prop("checked");
		if (status == false) {
			$(document).find(".cbox").removeProp("checked");
		} else {
			$(document).find(".cbox").prop("checked", "checked");
		}
	});
	$("#time-text").bind("input propertychange", function() {
		var str1 = "XXX同学您好，";
		var str2 = "将于扬华办公室(031037)召开全员例会，请准时参加，若有事需向主编刘禺杉请假。谢谢!";
		$("#overview").html(str1 + $("#time-text").val() + str2);
	});
	//todo
	$("#time-fresh-text").bind("input propertychange", function() {
		var str1 = "XXX同学您好，";
		var str2 = "将于扬华办公室(031037)召开全员例会，请准时参加，若有事需向主编刘禺杉请假。谢谢!";
		$("#overview").html($() + str1 + $("#time-text").val() + str2);
	});
	//todo
	$("#place-fresh-text").bind("input propertychange", function() {
		var str1 = "XXX同学您好，";
		var str2 = "将于扬华办公室(031037)召开全员例会，请准时参加，若有事需向主编刘禺杉请假。谢谢!";
		$("#overview").html(str1 + $("#time-text").val() + str2);
	});
});