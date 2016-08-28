$(function(){
	$("#edit-submit").on("click",function(){
		var al = $("#modal-alert");
		al.removeClass("alert-success");
		al.addClass("alert-danger");
		al.html("修改失败");
		$.post("./action/user/edit_user.handle.php",
			{
				"userid" : $("#user-id").val(),
				"name" : $("#modal-text-name").val(),
				"tel" : $("#modal-text-tel").val()
			},function(data){
				var obj = JSON.parse(data);
				if(obj.state == "success"){
					al.removeClass("alert-danger");
					al.addClass("alert-success");
					al.html("修改成功");
					var seconds = 3;
					var str1 = '修改成功！ ';
					var str2 = ' 秒后跳转！<a href=\'javascript:location.reload()\' class=\'alert-link\' >立即关闭</a>';
					$('#modal-alert').html(str1+seconds+str2);
					var timer = window.setInterval(update,1000);
					al.removeClass("hidden");
					function update(){
						seconds--;
						$('#modal-alert').html(str1+seconds+str2);
						if(seconds <= 0){
							window.clearInterval(timer);
							location.reload();
						}
					}
				}
			},"text");
		al.removeClass("hidden");
	});
	
});