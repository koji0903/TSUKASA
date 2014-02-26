<?php 
	session_start();
	setcookie(session_name(), session_id(), time() + 60*60);

	require_once("./common.php");
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
	<?php
		disp_header();
	?>
<!-- コンテンツ -->
	<?php
		//フォームからのデータ受け取り
		$uname    = $_GET['uname'];
		$address  = $_GET['address'];
		$mail     = $_GET['mail'];
		$password = $_GET['password'];
		
		$db = db();
		
		$sql = $db->prepare('SELECT * from user WHERE mail = :mail ');
		$sql->bindValue(':mail',$mail);
		$sql->execute();
		$data = $sql->fetchAll();
		
		if(!$data){
			$sql = $db->prepare('INSERT INTO user ( uname, address, mail, password )VALUES ( :uname, :address, :mail, :password) ');

			$sql->bindValue(':uname',$uname);
			$sql->bindValue(':address',$address);
			$sql->bindValue(':mail',$mail);
			$sql->bindValue(':password',md5($password));
			//SQLの実行
			if( $sql->execute() ){
				//成功した場合の処理
				echo '追加しました<br>';
				echo '<a href = "top.php">商品一覧ページへ</a>';
			}
			else{
				//失敗した場合の処理
				echo '追加に失敗しました<br>';
				echo '<a href = "registry.php">アカウント登録ページへ</a>';
			}
		}
		else{
			//失敗した場合の処理
			echo '同じメールアドレスが登録されています。<br>';
			echo '<a href = "registry.php">アカウント登録ページへ</a>';
		}
		//オブジェクトの解放
		$sql = null;
	?>

</body>
</html>
