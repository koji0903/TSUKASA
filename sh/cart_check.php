<?php 
	require_once("../common.php");
	session_start();
	setcookie(session_name(), session_id(), time()+60*5);


	// デバッグ
	if ( isset($_GET['debug']) ){
		$_SESSION['UID'] = 1;
		$gid = 1;
		$_GET['s_type'] = "daibiki";
		$debug = "&debug";
		$_SESSION['SID'] = array(2,7,13,4,11);
//		$_SESSION['SID'] = array();
	}else{
		$uid = $_SESSION['UID'];
		$gid = getGID($uid);		
	}


	if ( isset($_SESSION['UID']) ){
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
<?php
	disp_header2();
?>
<!-- コンテンツ -->
<?php
	if ( isset($_GET['s_type']) && $_GET['s_type'] != "" ){
		$s_type = $_GET['s_type'];
	}else{
		// 送金タイプが選択されていません。
		header("Location: ./cart_check2.html");
		exit;
	}

	// 合計金額の計算
	$sids = $_SESSION['SID'];
	$sid_count = count( $sids);
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
	if ( $sid_count != 0 ){
		if ( $shoukei < 10000 ){
			if( $s_type == "daibiki" ){
				$souryou = 1300;
			}else if( $s_type == "furikomi" ) {
				$souryou = 1000;
			}
		}else{
			if( $s_type == "daibiki" ){
				$souryou = 300;
			}
		}
	}

	$total = $shoukei + $souryou;
	echo "<br>";
	echo "<table>";
	echo "<tr>";
	echo "<th>小計</th>";
	echo "<td>{$shoukei}円</td>";
	echo "</tr>";
	echo "<th>送料</th>";
	if ( $s_type == "daibiki" ){
		echo "<td>{$souryou}円(代引きにより+300円)</td>";

	}else{
		echo "<td>{$souryou}円</td>";
	}
	echo "<tr>";
	echo "<th>合計</th>";
	echo "<td>{$total}円</td>";
	echo "</tr>";
	echo "</table>";


?>

<br>
<form action="./cart_check2.php">
<?php  
	if ( isset($_GET['debug']) ){
		echo "<input type=\"hidden\" name=\"debug\" value=1 >";
	}
	if ( $sid_count != 0 ){
		echo "<input type=\"submit\" name=\"buy\" value=\"購入\" >";
	}
?>
	<input type="submit" name="cancel" value="キャンセル" >
</form>

<?php 
	echo "<hr>";
	echo "購入予定製品：<br>";
	foreach( $sids as $sid ){
			$sql = $db->prepare('SELECT sid, sname, kakaku FROM shouhin WHERE sid = ?;');
			$sql->bindValue(1, $sid);
			$sql->execute();
			$data = $sql->fetch();
			$sname = htmlentities($data['sname'],ENT_QUOTES, "UTF-8");
			echo "{$sname} (価格：{$data['kakaku']}、商品番号：{$data['sid']})<br>";
	}
?>
</body>
</html>
