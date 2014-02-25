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
<link rel="stylesheet" href="my.css" content="text/css">
</head>
<body>
<h1>TSUKASA　Shop</h1>
<!-- ヘッダー -->

<!-- コンッ��-->
<h2>カート一覧</h2>
<!-- delオプション挮�時 -->
<?php
	if ( isset( $_GET['del'] ) ) {
		$index = array_search( $_GET['del'], $_SESSION['SID']);
		if ( $index !== FALSE ) {
			// echo "{$index}を削除しました<br>";
			unset( $_SESSION['SID'][$index] );
		}
	}
?>
<!-- セヂ�ョンからカート情報を取�-->
<?php
	$cart = $_SESSION['SID'];
?>

<!-- �ブル表示 -->
<?php
if ( count($cart) > 0 ) {
	echo "<table border=1>\n";
	echo '<thead>';
	echo '<th>ID(ッ�ヂ�)</th>'; // ッ�ヂ�
	echo '<th>啓��/th>';
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
			echo "<td>", $data['sid'], "</td>"; // ッ�ヂ�
			$sname = (isset($data['sname'])) ? htmlentities(
				$data['sname'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $sname, "</td>";
			echo "<td>", $data['kakaku'], "</td>";
			echo '<td><a href="cart.php?del=',
				$data['sid'], '">削除</a></td>';
			echo "</tr>\n";
			$sum += $data['kakaku'];
		}
		$sql = null; // オブジェクト�解放
	}
	echo "</table>";
	echo "<p>小計��額：{$sum} �/p>"
// 下�elseに続く
?>

<!--  -->
<form method="GET" action="cart_check.php">
	送�タイ�
	<select name="s_type">
		<option value="" selected></option>
		<option value="振込">振込</option>
		<option value="代引き">代引き</option>
	</select><br>
	<input type="submit" value="確�>
</form>

<?php
// 続き
} else {
	echo 'カート�空です�br>';
	echo '<a href="../top.php">啓�一覧へ戻�/a><br>';
}
?>

</body>
</html>
