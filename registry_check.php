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
	<?php
		disp_header();
	?>
<!-- コンテンツ -->
	<?php
		if(mb_strlen($_GET[ 'uname' ]) > 30 ||
		   mb_strlen($_GET[ 'address' ] > 100) || 
		   mb_strlen($_GET[ 'mail' ] > 50) ){
			header("Location: ./registry.php?flag=1");
		}

		$uname    = htmlentities($_GET[ 'uname' ],ENT_QUOTES,'UTF-8');
		$address  = htmlentities($_GET[ 'address' ],ENT_QUOTES,'UTF-8');
		$mail     = htmlentities($_GET[ 'mail' ],ENT_QUOTES,'UTF-8');
		

		echo "<p>氏名：", $uname, "</p>";
		echo "<p>住所：", $address, "</p>";
		echo "<p>メールアドレス：", $mail, "</p>";
		
	?>
	<form action="registry_check2.php" method="get">
		<input type="hidden" name="uname" value= <?php echo $_GET[ 'uname' ];?>><br>
		<input type="hidden" name="address" value= <?php echo $_GET[ 'address' ];?>><br>
		<input type="hidden" name="mail" value= <?php echo $_GET[ 'mail' ];?>><br>
		<input type="hidden" name="password" value= <?php echo $_GET['password'];?>><br>
		<input type="submit" value="OK">
	</form>
	<form action="registry.php" method="get">
		<input type="submit" value="NG">
	</form>

</body>
</html>
