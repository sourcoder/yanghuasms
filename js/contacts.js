$(function() {
	$(".btn-edit").on("click",function(){
		var td = $(this).parent().parent();
		var phone = td.prev();
		var name = phone.prev().html();
		phone = phone.html();
		var group = td.parent().parent().parent().parent().prev().children(".panel-title").first().children("label").first().html();
		$("#edit-modal-title").html("编辑联系人");
		$("#edit-name").val(name);
		$("#edit-phone").val(phone);
		$("#edit-selecet").val(group);
		$("#edit-modal").modal();
	});
	$("#add-contact").on("click",function(){
		$("#edit-modal-title").html("添加联系人");
		$("#edit-name").val("");
		$("#edit-phone").val("");
		$("#edit-selecet").val("");
		$("#edit-modal").modal();
	});
	$(".glyphicon-wrench").on("click",function(){
		var name = $(this).parent().parent().prev().html();
		$("#contacts-modal-title").html("编辑群组");
		$("#contacts-name").val(name);
		$("#contacts-modal").modal();
		return false;
	});
	$("#add-group").on("click",function(){
		$("#contacts-modal-title").html("添加群组");
		$("#contacts-name").val("");
		$("#contacts-modal").modal();
	});
	$(".btn-delete").on("click",function(){
		var name = $(this).parent().parent().prev().prev().html();
		$("#delete-modal-title").html("删除联系人");
		$("#delete-text").html(name);
		$("#delete-modal").modal();
	});
	$(".glyphicon-remove").on("click",function(){
		var name = $(this).parent().parent().prev().html();
		$("#delete-modal-title").html("删除群组");
		$("#delete-text").html(name);
		$("#delete-modal").modal();
		return false;
	});
});