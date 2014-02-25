<?php 
	require_once("./common.php");
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
	disp_header();
<!-- コンテンツ -->
	<?php
		$uname    = htmlentities($_GET[ 'uname' ],ENT_QUOTES,'UTF-8');
		$address  = htmlentities($_GET[ 'address' ],ENT_QUOTES,'UTF-8');
		$mail     = htmlentities($_GET[ 'mail' ],ENT_QUOTES,'UTF-8');
		$password = htmlentities($_GET['password'],ENT_QUOTES,'UTF-8');
		
		echo "<p>氏名：", $uname, "</p>";
		echo "<p>住所：", $address, "</p>";
		echo "<p>メールアドレス：", $password, "</p>";
		
	?>
	<form action="registry_check2.php" method="get">
		<input type="hidden" name="uname" value= <?php echo $uname;?>><br>
		<input type="hidden" name="address" value= <?php echo $address;?>><br>
		<input type="hidden" name="mail" value= <?php echo $mail;?>><br>
		<input type="hidden" name="password"><br>
		<input type="submit" value="OK">
	</form>
	<form action="registry.php" method="get">
		<input type="submit" value="NG">
	</form>

</body>
</html>
