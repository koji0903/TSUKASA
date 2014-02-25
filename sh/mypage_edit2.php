<?php 
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

<!-- コンテンツ -->
<?php 

	session_start();		

	if(isset($_SESSION['uid'])){
		$uid = $_SESSION['uid']  ;
		$gid=getGID($uid);
		if (!$gid){
			header("location:../maintenance.php") ;
		}
		
	}else{
		header("location:http://localhost/TSUKASA/login.php");
	}

	$uname =$_POST['uname'] ;
	$password =$_POST['password'] ;
	$mail =$_POST['mail'] ;
	$address =$_POST['address'] ;

	if (!empty($uid) && !empty($uname) &&!empty($mail) &&!empty($address)){
		$db = db();
		if(!empty($password)){ 
			$sql = $db->prepare("UPDATE user SET uname=?,password=?,mail=?,address=? WHERE uid=?");
			$sql->bindValue(1,$uname);
			$sql->bindValue(2,md5($password));
			$sql->bindValue(3,$mail);
			$sql->bindValue(4,$address);
			$sql->bindValue(5,$uid) ;
		}else{
			$sql = $db->prepare("UPDATE user SET uname=?,mail=?,address=? WHERE uid=?");
			$sql->bindValue(1,$uname);
			$sql->bindValue(2,$mail);
			$sql->bindValue(3,$address);
			$sql->bindValue(4,$uid) ;
		}
		if ($sql->execute()){
			header("location:http:./mypage_show.php");
		}else {
			header("location:http:./mypage_edit.php");
		}
	}else {
		header("location:http:./mypage_edit.php");
	}

?>


</body>
</html>
