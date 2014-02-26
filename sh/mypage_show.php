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

	echo '<table>';
	echo '<caption>登録情報</caption>' ;
		foreach ($all as $data){
				$uname2=htmlentities($data['uname'],ENT_QUOTES,'UTF-8') ;
				echo "<tr><th>氏名</th><td>$uname2</td></tr>";
				$address2=htmlentities($data['address'],ENT_QUOTES,'UTF-8') ;
				echo "<tr><th>住所</th><td>$address2</td></tr>" ;
				$mail2=htmlentities($data['mail'],ENT_QUOTES,'UTF-8') ;
				echo "<tr><th>e-mail</th><td>$mail2</td></tr>";
				echo "<tr><th>パスワード</th><td>非表示</td></tr>";
		}
	echo '</table>' ;
	$sql=null ;
?>

<br><br>

　<a href="mypage_edit.php" >登録情報変更</a><br>
  <a href="mypage.php" >戻る</a>

</body>
</html>
