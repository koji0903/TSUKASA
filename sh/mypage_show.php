<?php 
	require_once("./../common.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" href="my.css" content="text/css">
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
			header("location:http:../maintenance.php") ;
		}
		
	}else{
		header("location:http:../login.php");
	}
	
	$db = db();
	$sql = $db->prepare("SELECT * FROM user WHERE uid=?");
	$sql->bindValue(1,$uid) ;
	$sql->execute();

	$all = $sql->fetchALL();

	echo '<table>';
	echo '<caption>登録情報</caption>' ;
		foreach ($all as $data){
				$uname2=htmlentities($data['uname'],ENT_QUOTES,'UTF-8') ;
				echo "<tr><td>氏名</td><td>$uname2</td></tr>";
				$address2=htmlentities($data['address'],ENT_QUOTES,'UTF-8') ;
				echo "<tr><td>住所</td><td>$address2</td></tr>" ;
				$mail2=htmlentities($data['mail'],ENT_QUOTES,'UTF-8') ;
				echo "<tr><td>e-mail</td><td>$mail2</td></tr>";
		}
	echo '</table>' ;
?>

<br>
　<a href="mypage_edit.php" >登録情報変更</a><br>
  <a href="mypage.php" >マイページ</a>

</body>
</html>
