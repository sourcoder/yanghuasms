$(function(){
	var nowid = null;
	function showmsg(al,func,url,jsondata){
		al.addClass("hidden");
		al.removeClass("alert-success");
		al.removeClass("alert-danger");
		al.html(func+"失败");
		$.post(url,jsondata,function(data){
				var obj = JSON.parse(data);
				if(obj.state == "success"){
					al.addClass("alert-success");
					al.removeClass("alert-danger");
					al.html(func+"成功");
					var seconds = 3;
					var str1 = func+'成功！ ';
					var str2 = ' 秒后关闭！<a href=\'javascript:location.reload()\' class=\'alert-link\' >立即关闭</a>';
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
					al.html(func+"失败!"+obj.msg);
				}
			},"text");
		al.removeClass("hidden");
	}
	$("#add-member").on("click",function(){
		$("#add-member-modal").find(".alert").first().addClass("hidden");
		$("#add-member-modal").modal();
	});
	$("#add-member-btn").on("click",function(){
		var al = $("#add-member-modal").find(".alert").first();
		var ob = {
				"username" : $("#add-member-name").val(),
				"organization" : $("#oid").val()
			};
		showmsg(al,"添加","./action/organization/add_member.handle.php",ob);
	});
	$("#transfer-admin").on("click",function(){
		$("#transfer-admin-modal").modal();
	});
	$("#transfer-admin-btn").on("click",function(){
		var al = $("#transfer-admin-modal").find(".alert").first();
		var ob = {
				"userid" : $("#transfer-user").val(),
				"organization" : $("#oid").val()
			};
		showmsg(al,"转让","./action/organization/transfer_admin.handle.php",ob);
	});
	$(".btn-edit").on("click",function(){
		nowid = $(this).attr("uid");
		var state = $(this).parent().parent().prev();
		var name = state.prev();
		var username = name.prev();
		$("#member-username").val(username.html());
		$("#member-name").val(name.html());
		var s = state.html();
		var va = 0;
		if($.trim(s)=="成员")
			va = 20;
		else if($.trim(s)=="协管员")
			va = 60;
		$("#member-permission").val(va);
		$("#edit-member-modal").modal();
	});
	$("#edit-member-btn").on("click",function(){
		var al = $("#edit-member-modal").find(".alert").first();
		var ob = {
				"userid" : nowid,
				"organization" : $("#oid").val(),
				"permission" : $("#member-permission").val()
			};
		showmsg(al,"编辑","./action/organization/edit_member.handle.php",ob);
	});
	$(".btn-delete").on("click",function(){
		nowid = $(this).attr("uid");
		var username = $(this).parent().parent().prev().prev().prev().html();
		$("#delete-member-modal").find(".modal-msg").first().html(username);
		$("#delete-member-modal").modal();
	});
	
});