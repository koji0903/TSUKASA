<?php
	require_once("../common.php");

	// ログインチェック
  session_start();
	// ログイン状態のチェック
	if (!isset($_SESSION["UID"])) {
	  header("Location: ../login.php");
	  exit;
	}else{
		$gid = getGID($_SESSION['UID']);
		if( $gid != 0 ){
		  header("Location: ../top.php");
		  exit;
		}
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
	<?php
		disp_header2();
	?>
<!-- コンテンツ -->
  <?php
    $sid = $_GET['sid'];

    // 共通
	  $db = db();

		// すでに登録済みでないか確認
		$sql = $db->prepare( 'SELECT * FROM shouhin JOIN category ON shouhin.cid=category.cid AND sid=:sid;');
		$sql->bindValue(':sid',$sid);
		$sql->execute();
		$data = $sql->fetch();
		$sql = null;
  ?>

	<h3>以下の商品を削除します。</h3><br>
	商品ID　：　<?php echo $data['sid'] ?><br>
	商品名　：　<?php echo htmlentities( $data['sname'], ENT_QUOTES, "UTF-8" ) ?><br>
	カテゴリ　：　<?php echo htmlentities( $data['cname'], ENT_QUOTES, "UTF-8" ) ?><br>
	価格　：　<?php echo $data['kakaku'] ?><br><br>

	<textarea name="setsumei" cols="30" rows="20" readonly>
		<?php  echo htmlentities( $data['setsumei'], ENT_QUOTES, "UTF-8" ) ?>
	</textarea></p>

	<p>
	  <?php
	  if( file_exists('../img/' . $sid . '.jpg')){
	  	echo '<img src="../img/' . $sid . '.jpg" alt="' . $data['sname'] . '"><br>';
	  }else{
	  	echo '<p>no picture</p>';
	  }
	  ?>
  </p>

  <form method="GET" action="goods_del2.php">
    <input type="hidden" name="sid" value="<?php echo $sid ?>">
    <input type="submit" value="削除実行">
  </form>
  <p><a href="goods_main.php"><button>キャンセル</button></a></p>

</body>
</html>
