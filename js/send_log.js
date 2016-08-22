$(function() {
	$('td').each(function(){
		$(this).attr("data-toggle", "tooltip");
		$(this).attr("data-placement", "top");
		$(this).attr("data-original-title", $(this).html());
		$(this).attr("data-trigger", "click");
	});
	$('td').on("click", function() {
		$(this).tooltip();
	});
});