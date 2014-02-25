<?php 
	require_once("../common.php");

	// デバッグ
	$_SESSION['uid'] = 1;

	if ( isset($_SESSION['uid']) ){
		$uid = $_SESSION['uid'];
		if ( getGID($uid) == 0 ){
			// 管理者であった場合は、管理者ページへリダイレクト			
//			header("Location: http://localhost/TSUKASA/maintenance.php");
//			exit;		
		}
	}else{
		// UIDが設定されていなければ、ログイン画面へリダイレクト
		header("Location: ../login.php");
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
<?php
	if ( isset($_GET['s_type']) ){
		$s_type = $_GET['s_type'];
	}else{
		// 送金タイプが選択されていません。
		header("Location: ./cart_check2.html");
		exit;
	}

	// 合計金額の計算
	$_SESSION['SID'] = array(1,4,5,10);

?>
</body>
</html>
