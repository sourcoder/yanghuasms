$(function(){
	var nowid = null;
	$("#add-member").on("click",function(){
		$("#add-member-modal").find(".alert").first().addClass("hidden");
		$("#add-member-modal").modal();
	});
	$("#add-member-btn").on("click",function(){
		var al = $("#add-member-modal").find(".alert").first();
		al.removeClass("alert-success");
		al.removeClass("alert-danger");
		al.html("添加失败");
		$.post("./action/organization/add_member.handle.php",
			{
				"username" : $("#add-member-name").val(),
				"organization" : $("#oid").val()
			},function(data){
				var obj = JSON.parse(data);
				if(obj.state == "success"){
					al.addClass("alert-success");
					al.removeClass("alert-danger");
					al.html("添加成功");
					var seconds = 3;
					var str1 = '添加成功！ ';
					var str2 = ' 秒后跳转！<a href=\'javascript:location.reload()\' class=\'alert-link\' >立即关闭</a>';
					al.html(str1+seconds+str2);
					var timer = window.setInterval(update,1000);
					al.removeClass("hidden");
					function update(){
						seconds--;
						al.html(str1+seconds+str2);
						if(seconds <= 0){
							window.clearInterval(timer);
							location.reload();
						}
					}
				}else{
					al.addClass("alert-danger");
					al.html("添加失败!"+data.msg);
				}
			},"text");
		al.removeClass("hidden");
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
		var s = state.html();
		var va = 0;
		if($.trim(s)=="成员")
			va = 40;
		else if($.trim(s)=="协管员")
			va = 60;
		$("#member-permission").val(va);
		$("#edit-member-modal").modal();
		nowid = $(this).attr("uid");
	});
	$(".btn-delete").on("click",function(){
		
		var username = $(this).parent().parent().prev().prev().prev().html();
		$("#delete-member-modal").find(".modal-msg").first().html(username);
		$("#delete-member-modal").modal();
	})
	

});