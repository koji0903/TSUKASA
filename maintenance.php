<?php
	session_start();
	setcookie(session_name(), session_id(), time()+60);
	require_once("./common.php");
	// debug
	if ( isset($_GET['debug']) ) {
		$_SESSION['UID'] = 2;
	}
	if ( ! isset($_SESSION['UID']) ) {
		header("Location: login.php");
		exit;
	} else 	if ( getGID($_SESSION['UID']) != 0 ) {
		header("Location: top.php");
		exit;
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

<!-- コンテンツ -->
<p>
	<a href="./ma/goods_main.php">商品操作</a>
</p>

<p>
	<a href="./ma/category_main.php">カテゴリ操作</a>
</p>

<p>
	<a href="./ma/history_main.php">履歴参照</a>
</p>

</body>
</html>
