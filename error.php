<?php 
	require_once("./common.php");
	$_SESSION = array();

	if (isset($_COOKIE["PHPSESSID"])) {
		setcookie("PHPSESSID", '', time() - 1800, '/');
	}

	session_destroy();
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
	<h2>想定外のエラーです</h2>

	<p><a href="login.php">ログイン画面へ</a><p>

</body>
</html>
