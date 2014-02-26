<?php
	session_start();
	setcookie(session_name(), session_id(), time()+60);
	require_once("../common.php");
	// debug
	$_SESSION['UID'] = 1;
	if ( isset($_GET['debug']) ) {
		$_SESSION['SID'] = array(5, 6, 7, 8, 9);
	}
	if ( ! isset($_SESSION['UID']) ) {
		header("Location: ../login.php");
		exit;
	} else 	if ( getGID($_SESSION['UID']) != 1 ) {
		header("Location: ../maintenance.php");
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
<h2>カート一覧</h2>
<!-- delオプション指定時 -->
<?php
	if ( isset( $_GET['del'] ) ) {
		$index = array_search( $_GET['del'], $_SESSION['SID']);
		if ( $index !== FALSE ) {
			// echo "{$index}を削除しました<br>";
			unset( $_SESSION['SID'][$index] );
		}
	}
?>
<!-- セッションからカート情報を取得 -->
<?php
	$cart = (isset($_SESSION['SID'])) ? $_SESSION['SID'] : null;
?>

<!-- テーブル表示 -->
<?php
if ( count($cart) > 0 ) {
	echo "<table border=1>\n";
	echo '<thead>';
	echo '<th>ID(デバッグ)</th>'; // デバッグ
	echo '<th>商品名</th>';
	echo '<th>価格</th>';
	echo '<th>削除</th>';
	echo "</thead>\n";
	$sum = 0;
	foreach ( $cart as $sid ) {
		$db = db();
		$sql = $db->prepare("SELECT * FROM shouhin WHERE sid=:sid");
		$sql->bindValue(':sid', $sid);
		$sql->execute();
		$data = $sql->fetch();
		if ( $data ) {
			echo "<tr>";
			echo "<td>", $data['sid'], "</td>"; // デバッグ
			$sname = (isset($data['sname'])) ? htmlentities(
				$data['sname'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $sname, "</td>";
			echo "<td>", $data['kakaku'], "</td>";
			echo '<td><a href="cart.php?del=',
				$data['sid'], '">削除</a></td>';
			echo "</tr>\n";
			$sum += $data['kakaku'];
		}
		$sql = null; // オブジェクトの解放
	}
	echo "</table>";
	echo "<p>小計金額：{$sum} 円</p>"
// 下のelseに続く
?>

<!--  -->
<form method="GET" action="cart_check.php">
	送金タイプ:
	<select name="s_type">
		<option value="" selected></option>
		<option value="soukin">振込</option>
		<option value="daibiki">代引き</option>
	</select><br>
	<input type="submit" value="確認">
</form>

<?php
// 続き
} else {
	echo 'カートは空です。<br>';
	echo '<a href="../top.php">商品一覧へ戻る</a><br>';
}
?>

</body>
</html>
