<?php 
	session_start();
	setcookie(session_name(), session_id(), time() + 60*60);

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
		if(isset($_GET['flag'])){ 
			$flag = $_GET['flag'];
		}
		else{
			$flag = 0;
		}
	?>
	<?php 
		if(isset($_GET['uname'])){
			$uname = $_GET['uname'];
		}
		else{
			$uname = "";
		}
		if(isset($_GET['address'])){
			$address = $_GET['address'];
		}
		else{
			$address = "";
		}
		if(isset($_GET['mail'])){
			$mail = $_GET['mail'];
		}
		else{
			$mail = "";
		}
	?>

	<h1>アカウント登録</h1>
	<?php
		if($flag == 1){
			echo "<p>入力情報の文字数が多すぎます。</p>";
		}
	?>
	<form action="registry_check.php" method="get">
		氏名：<input type="text" name="uname" value= "<?php echo $uname;?>"><br>
		住所：<input type="text" name="address" value= "<?php echo $address;?>"><br>
		メールアドレス：<input type="text" name="mail" value= "<?php echo $mail;?>"><br>
		パスワード：<input type="password" name="password"><br>
		<input type="submit" value="確認">
	</form>
	<form action="login.php" method="get">
		<input type="submit" value="キャンセル">
	</form>

</body>
</html>
