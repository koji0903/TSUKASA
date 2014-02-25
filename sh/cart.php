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
<h1>TSUKASAã€€Shop</h1>
<!-- ãƒ˜ãƒƒãƒ€ãƒ¼ -->

<!-- ã‚³ãƒ³ãƒƒ³ãƒ-->
<h2>ã‚«ãƒ¼ãƒˆä¸€è¦§</h2>
<!-- delã‚ªãƒ—ã‚·ãƒ§ãƒ³æŒ®šæ™‚ -->
<?php
	if ( isset( $_GET['del'] ) ) {
		$index = array_search( $_GET['del'], $_SESSION['SID']);
		if ( $index !== FALSE ) {
			// echo "{$index}ã‚’å‰Šé™¤ã—ã¾ã—ãŸ<br>";
			unset( $_SESSION['SID'][$index] );
		}
	}
?>
<!-- ã‚»ãƒ‚·ãƒ§ãƒ³ã‹ã‚‰ã‚«ãƒ¼ãƒˆæƒ…å ±ã‚’å–å¾-->
<?php
	$cart = $_SESSION['SID'];
?>

<!-- ãƒãƒ–ãƒ«è¡¨ç¤º -->
<?php
if ( count($cart) > 0 ) {
	echo "<table border=1>\n";
	echo '<thead>';
	echo '<th>ID(ãƒƒãƒ‚°)</th>'; // ãƒƒãƒ‚°
	echo '<th>å•“å/th>';
	echo '<th>ä¾¡æ ¼</th>';
	echo '<th>å‰Šé™¤</th>';
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
			echo "<td>", $data['sid'], "</td>"; // ãƒƒãƒ‚°
			$sname = (isset($data['sname'])) ? htmlentities(
				$data['sname'],ENT_QUOTES,'UTF-8') : "";
			echo "<td>", $sname, "</td>";
			echo "<td>", $data['kakaku'], "</td>";
			echo '<td><a href="cart.php?del=',
				$data['sid'], '">å‰Šé™¤</a></td>';
			echo "</tr>\n";
			$sum += $data['kakaku'];
		}
		$sql = null; // ã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆãè§£æ”¾
	}
	echo "</table>";
	echo "<p>å°è¨ˆéßé¡ï¼š{$sum} å†/p>"
// ä¸‹ãelseã«ç¶šã
?>

<!--  -->
<form method="GET" action="cart_check.php">
	é€ßã‚¿ã‚¤ãƒ
	<select name="s_type">
		<option value="" selected></option>
		<option value="soukin">送金</option>
		<option value="daibiki">代引き</option>
	</select><br>
	<input type="submit" value="ç¢ºèª>
</form>

<?php
// ç¶šã
} else {
	echo 'ã‚«ãƒ¼ãƒˆãç©ºã§ã™ã€br>';
	echo '<a href="../top.php">å•“ä¸€è¦§ã¸æˆ»ã‚/a><br>';
}
?>

</body>
</html>
