<?php 
	require_once("./../common.php");
	session_start();
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
	
	$db = db();
	$sql = $db->prepare("SELECT * FROM user WHERE uid=?");
	$sql->bindValue(1,$uid) ;
	$sql->execute();

	$all = $sql->fetchALL();

		foreach ($all as $data){
				$uname2=htmlentities($data['uname'],ENT_QUOTES,'UTF-8') ;
				$address2=htmlentities($data['address'],ENT_QUOTES,'UTF-8') ;
				$mail2=htmlentities($data['mail'],ENT_QUOTES,'UTF-8') ;
				$uid2=$data['uid'];
				$password2=htmlentities($data['password'],ENT_QUOTES,'UTF-8') ;
		}

	echo '</table>';

	if(isset($_GET['err_flag'])){
		echo "登録内容にエラーがあります";
	}
	$sql=null ;
?>
<form method="POST" action="mypage_edit2.php">
	<input type="hidden" name="uid" value="<?php echo $uid2; ?>">
	氏名<input type="text" name="uname" value="<?php echo $uname2; ?>"><br>
	パスワード<input type="password" name="password" value=""><br>
	e-mail<input type="text" name="mail" value="<?php echo $mail2; ?>"><br>
	住所<input type="text" name="address" value="<?php echo $address2; ?>"><br>
	<input type="submit" value="登録"></a>
</form>
<br>
　<a href="mypage_show.php" >戻る</a><br>
<br>
  <a href="mypage.php" >マイページ</a>

</body>
</html>
