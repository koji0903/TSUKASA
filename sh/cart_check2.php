<?php 
	require_once("../common.php");
	session_start();
	setcookie(session_name(), session_id(), time()+60*5);

	// デバッグ
	if ( isset($_GET['debug']) ){
		$_SESSION['UID'] = 1;
		$gid = 1;
	}else{
		$gid = getGID($uid);		
	}


	if ( isset($_SESSION['UID']) ){
		$uid = $_SESSION['UID'];
		if ( $gid == 0 ){
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
<link rel="stylesheet" href="../my.css" content="text/css">
</head>
<body>
<h1>TSUKASA　Shop</h1>
<!-- ヘッダー -->

<!-- コンテンツ -->
<?php
	// キャンセル
	if ( isset($_GET['cancel']) ){
		// キャンセルの場合は、カート画面へ
		if ( isset($_GET['debug']) ){
			header("Location: http://localhost/TSUKASA/sh/cart.php?debug");		
			$_SESSION['UID'] = 1;
		}else{
		header("Location: cart.php");		
		}
	}

	// 購入
	if ( isset($_GET['buy']) ){
		$sids = $_SESSION['SID'];
		$db = db();

		foreach( $sids as $sid ){
			$sql = $db->prepare('INSERT INTO rireki ( uid, hizuke, sid ) VALUES ( ?, now(), ?)');
			$sql->bindValue(1, $uid);
			$sql->bindValue(2, $sid);
			if ( $sql->execute() ){
			}else{
			}
		}
		// SESSIONクリア
		$_SESSION['SID'] = array();
		header("Location: mypage.php");			
	}

?>


</body>
</html>
