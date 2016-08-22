$(function(){
	$("#add-member").on("click",function(){
		$("#add-member-modal").modal();
	});
	$("#transfer-admin").on("click",function(){
		$("#transfer-member-modal").modal();
	});
	$(".btn-edit").on("click",function(){
		var state = $(this).parent().parent().prev();
		var name = state.prev();
		var username = name.prev();
		$("#member-username").val(username.html());
		$("#member-name").val(name.html());
		$("#member-permission").val(state.html());
		$("#edit-member-modal").modal();
	});
});