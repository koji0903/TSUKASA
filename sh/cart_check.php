<?php 
	require_once("../common.php");
	session_start();
	setcookie(session_name(), session_id(), time()+60*5);


	// デバッグ
	if ( isset($_GET['debug']) ){
		$_SESSION['uid'] = 1;
		$gid = 1;
	}else{
		$gid = getGID($uid);		
	}


	if ( isset($_SESSION['uid']) ){
		$uid = $_SESSION['uid'];
		if (  $gid == 0 ){
			// 管理者であった場合は、管理者ページへリダイレクト			
			header("Location: http://localhost/TSUKASA/maintenance.php");
			exit;		
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
	if ( isset($_GET['debug']) ){
			$s_type = "furikomi";
			$debug = "&debug";
	}else{
		$s_type = "";
		if ( isset($_GET['s_type']) ){
			$s_type = $_GET['s_type'];
		}else{
			// 送金タイプが選択されていません。
			header("Location: ./cart_check2.html");
			exit;
		}
	}

	// 合計金額の計算
	$_SESSION['SID'] = array(1,10);
	$sids = $_SESSION['SID'];
	$db = db();

	$shoukei = 0;
	foreach( $sids as $sid ){
			$sql = $db->prepare('SELECT kakaku FROM shouhin WHERE sid = ?;');
			$sql->bindValue(1, $sid);
			$sql->execute();
			$data = $sql->fetch();
			$shoukei += $data['kakaku'];
	}

	// 送料の計算
	$souryou = 0;
	if ( $shoukei < 10000 ){
		if( $s_type == "furikomi" ){
			$souryou = 1300;
		}else{
			$souryou = 1000;
		}
	}

	$total = $shoukei + $souryou;
	echo "<table>";
	echo "<tr>";
	echo "<th>小計</th>";
	echo "<td>{$shoukei}円</td>";
	echo "</tr>";
	echo "<th>送料</th>";
	echo "<td>{$souryou}円</td>";
	echo "<tr>";
	echo "<th>合計</th>";
	echo "<td>{$total}円</td>";
	echo "</tr>";
	echo "</table>";

?>

</body>
</html>
