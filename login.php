<?php 
	session_start();
	setcookie(session_name(), session_id(), time() + 60*60);
	
	require_once("./common.php");
	
	if(isset($_SESSION["uid"])){
		$gid = getGID($_SESSION["uid"]);
		if($gid == 1){ //ユーザ権限
			header("Location: ./top.php");
			exit;
		}
		else{ //管理者権限
			header("Location: ./maintenance.php");
			exit;
		}
	}
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

	<h1>ログイン画面</h1>
	<form action="login2.php" method="get">
		メールアドレス：<input type="text" name="mail"><br>
		パスワード：<input type="password" name="password"><br>
		<input type="submit" value="ログイン">
	</form>
	<p><a href="registry.php">アカウント登録</a><p>

</body>
</html>
