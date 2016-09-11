<html>
	<head>
		<meta charset="utf-8">
		</head></html>
<?php
include 'conn.php';
include 'function.php';
require "image_class.php";
$stuname = $_POST['stuname'];
$stunumber = $_POST['stunumber'];
$birth = $_POST['birth'];
$jiguan = $_POST['jiguan'];
$zhuanye = $_POST['zhuanye'];
$phone = $_POST['phone'];
$qq = $_POST['qq'];
if (isset($_POST['blend'])) {
	$blend = $_POST['blend'];
} else {
	$blend = "no";
}
$blend = $_POST['blend'];
$minzu = $_POST['minzu'];
$sex = $_POST['sex'];
$part1 = $_POST['part1'];
$part2 = $_POST['part2'];
$introduce = $_POST['introduce'];
$hope = $_POST['hope'];
$query = "select * from applylist where stunumber = '" . $stunumber . "'";
$result = mysql_query($query);
$num = mysql_num_rows($result);
if ($num != 0) {
	//如果数据库里已经存在
	if (isset($_FILES['uploadPhoto']['name'])) {
		//上传图片
		$p = new SaeStorage();
		$photo = $_FILES['uploadPhoto']['name'];
		$end = substr(strrchr($photo, '.'), 1); //获取后缀名
		$name = time() . "." . $end;
		/*********************************************************************
			if($_FILES['uploadPhoto']['type']=="image/jpeg"){
			$image = imagecreatefromjpeg($_FILES['uploadPhoto']["tmp_name"]);
			}else if($_FILES['uploadPhoto']['type']=="image/png"){
				$image = imagecreatefrompng($_FILES['uploadPhoto']["tmp_name"]);
			}elseif ($_FILES['uploadPhoto']['type']=="image/gif"){
				$image = imagecreatefromgif($_FILES['uploadPhoto']["tmp_name"]);
			}else{
				$image = imagecreatefromwbmp($_FILES['uploadPhoto']["tmp_name"]);
			}
            ************************************************************************/
		$tmp_name = $_FILES['uploadPhoto']["tmp_name"];
		$giftpicname = "yanghua/apply/imgs/" . $name; //上传到workpress下的yanghua/apply/imgs文件下
		if ($_FILES['uploadPhoto']['type'] == ("image/jpeg" || "image/gif" || "image/png")) {
			$result = $p->upload("workpress", $giftpicname, $tmp_name);
			if ($result) {
				$url = "saestor://workpress/yanghua/apply/imgs/" . $name;
				$imagedata = getimagesize($url);
				$olgWidth = $imagedata[0];
				$oldHeight = $imagedata[1];
				//			$newWidth = 295;
				//$newHeight = 413;
				//  resize($url,$newWidth,$newHeight,"yanghua/apply/imgs/");//改变大小替换原图
				//等比压缩，改变大小替换原图
				$src = "http://yanghuae-workpress.stor.sinaapp.com/yanghua/apply/imgs/" . $name;
				$image = new Image($src);
				$image->thumb(147, 206);
				$image->save();
				$name = $p->getUrl("workpress", "yanghua/apply/imgs/" . $name);

				$sql = "UPDATE applylist
SET stuname ='" . $stuname . "',birth = '" . $birth . "',jiguan = '" . $jiguan . "',zhuanye = '" . $zhuanye . "',phone = '" . $phone . "',photo = '" . $name . "',minzu = '" . $minzu . "',
				sex = '" . $sex . "',position1 = '" . $part1 . "',position2 = '" . $part2 . "',introduce = '" . $introduce . "',hope = '" . $hope . "',time= now() ,qq='" . $qq . "',blend='" . $blend . "'
WHERE stunumber = '" . $stunumber . "' ";
			} else {
				echo "<script>alert(\"图片上传错误！\");</script>";
			}

		}

		//$imagedata = getimagesize($_FILES['uploadPhoto']["tmp_name"]);
		/**********************************************************************
			$thumb = imagecreatetruecolor ($newWidth, $newHeight);
			imagecopyresized ($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $olgWidth, $oldHeight);
			imagejpeg($thumb, "imgs/".$name);
			imagedestroy($thumb);
			imagedestroy($image);
            **********************************************************************/
		//$copy=move_uploaded_file($_FILES['uploadPhoto']["tmp_name"],"imgs/".$name);

	} else {

		$sql = "UPDATE applylist
SET stuname ='" . $stuname . "',stunumber = '" . $stunumber . "',birth = '" . $birth . "',jiguan = '" . $jiguan . "',zhuanye = '" . $zhuanye . "',phone = '" . $phone . "',minzu = '" . $minzu . "',
				sex = '" . $sex . "',position1 = '" . $part1 . "',position2 = '" . $part2 . "',introduce = '" . $introduce . "',hope = '" . $hope . "',time= now() ,qq='" . $qq . "',blend='" . $blend . "'
WHERE stunumber = '" . $stunumber . "' ";
	}
} else {
	//第一次申请
	$p = new SaeStorage();
	$photo = $_FILES['uploadPhoto']['name'];
	$end = substr(strrchr($photo, '.'), 1);
	$name = time() . "." . $end;
	$tmp_name = $_FILES['uploadPhoto']["tmp_name"];
	$giftpicname = "yanghua/apply/imgs/" . $name; //上传到workpress下的yanghua/apply/imgs文件下
	if ($_FILES['uploadPhoto']['type'] == ("image/jpeg" || "image/gif" || "image/png")) {
		$result = $p->upload("workpress", $giftpicname, $tmp_name);
		if ($result) {
			$url = "saestor://workpress/yanghua/apply/imgs/" . $name;
			$imagedata = getimagesize($url);
			$olgWidth = $imagedata[0];
			$oldHeight = $imagedata[1];
			$newWidth = 295;
			$newHeight = 413;
			//      resize($url,$newWidth,$newHeight,"yanghua/apply/imgs/");
			//等比压缩，改变大小替换原图
			$src = "http://yanghuae-workpress.stor.sinaapp.com/yanghua/apply/imgs/" . $name;
			$image = new Image($src);
			$image->thumb(147, 206);
			$image->save();
			$name = $p->getUrl("workpress", "yanghua/apply/imgs/" . $name);
			$sql = "INSERT INTO applylist (stuname,stunumber,birth,jiguan,zhuanye,phone,photo,minzu,sex,position1,position2,introduce,hope,time,qq,blend)
						VALUES ('$stuname','$stunumber','$birth','$jiguan','$zhuanye','$phone','$name','$minzu','$sex','$part1','$part2',
                        '$introduce','$hope',now(),'$qq','$blend')";
		} else {
			echo "<script>alert(\"图片上传错误！\");</script>";
		}

	}
	/***************************************************************************
		if($_FILES['uploadPhoto']['type']=="image/jpeg"){
				$image = imagecreatefromjpeg($_FILES['uploadPhoto']["tmp_name"]);
				}else if($_FILES['uploadPhoto']['type']=="image/png"){
					$image = imagecreatefrompng($_FILES['uploadPhoto']["tmp_name"]);
				}elseif ($_FILES['uploadPhoto']['type']=="image/gif"){
					$image = imagecreatefromgif($_FILES['uploadPhoto']["tmp_name"]);
				}
			$imagedata = getimagesize($_FILES['uploadPhoto']["tmp_name"]);
			$olgWidth = $imagedata[0];
			$oldHeight = $imagedata[1];
			$newWidth = 295;
			$newHeight = 413;
			$thumb = imagecreatetruecolor ($newWidth, $newHeight);
			imagecopyresized ($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $olgWidth, $oldHeight);
			imagejpeg($thumb, "imgs/".$name);
			imagedestroy($thumb);
			imagedestroy($image);
	*/
	//$copy=move_uploaded_file($_FILES['uploadPhoto']["tmp_name"],"imgs/".$name);

}
$result = mysql_query($sql);
echo "<script>alert(\"报名成功，欢迎加入扬华大家庭！面试的时间和地点之后会以短信的形式发送到手机上，请注意查收，届时请准时参加，再次感谢你的报名！\");window.history.go(-1)</script>";
?>