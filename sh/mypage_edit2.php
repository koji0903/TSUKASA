<?php 
	session_start();
	require_once("./../common.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" href="../my.css" content="text/css">
</head>
<body>
<h1>TSUKASA　Shop</h1>
<!-- ヘッダー -->
<?php
	disp_header2();
?>
<!-- コンテンツ -->
<?php 

	if(isset($_SESSION['UID'])){
		$uid = $_SESSION['UID']  ;
		$gid=getGID($uid);
		if (!$gid){
			header("location:../maintenance.php") ;
		}
		
	}else{
		header("location:../login.php");
	}

	$uname =$_POST['uname'] ;
	$password =$_POST['password'] ;
	$mail =$_POST['mail'] ;
	$address =$_POST['address'] ;

	$pattern="^(\s|　)+$"; 
	if(mb_ereg_match($pattern,$uname)||mb_ereg_match($pattern,$mail)||mb_ereg_match($pattern,$address)||mb_ereg_match($pattern,$password)){
		header("location:./mypage_edit.php?err_flag=1") ;
		exit ;
	}


	if (empty($_POST['uname']) || empty($_POST['mail']) || empty($_POST['address'])){
		header("location:./mypage_edit.php?err_flag=1") ;
		exit ;
	}


	if (empty($uid) && empty($uname) &&empty($mail) &&empty($address)){
		header("location:./mypage_edit.php");
	}else {
		$db = db();
		if(empty($password)){ 
			$sql = $db->prepare("UPDATE user SET uname=?,mail=?,address=? WHERE uid=?");
			$sql->bindValue(1,$uname);
			$sql->bindValue(2,$mail);
			$sql->bindValue(3,$address);
			$sql->bindValue(4,$uid) ;
		}else{
			$sql = $db->prepare("UPDATE user SET uname=?,password=?,mail=?,address=? WHERE uid=?");
			$sql->bindValue(1,$uname);
			$sql->bindValue(2,md5($password));
			$sql->bindValue(3,$mail);
			$sql->bindValue(4,$address);
			$sql->bindValue(5,$uid) ;
		}
		if ($sql->execute()){
			header("location:http:./mypage_show.php");
		}else {
			header("location:http:./mypage_edit.php");
		}
	}
	$sql=null ;
?>


</body>
</html>
