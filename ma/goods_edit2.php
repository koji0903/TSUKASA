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
  	$sid = $_POST['sid'];
    $sname = $_POST['sname'];
    $kakaku = $_POST['kakaku'];
    $setsumei = $_POST['setsumei'];
    $cid = $_POST['cid'];

    // 共通
	  $db = db();

		// すでに登録済みでないか確認
		$sql = $db->prepare('SELECT * FROM shouhin WHERE sname=:sname AND sid!=:sid ;');
		$sql->bindValue(':sid',$sid);
		$sql->bindValue(':sname',$sname);
		$sql->execute();
		$data = $sql->fetch();
		$sql = null;

		print_r($data);

		if( !empty($data) ){
			// データがすでに登録済みである場合はエラーフラグを返す。
		  header('Location: goods_edit.php?'.'sid='.$sid.'&err=1');
		  exit;
		}else{

			// 価格の入力チェック
			if( $kakaku <= 0 ){
			  header('Location: goods_edit.php?'.'sid='.$sid.'&err=2');
			  exit;
			}

			if( !empty($setsumei) ){
				$sql = $db->prepare('UPDATE shouhin SET sname=:sname,kakaku=:kakaku,setsumei=:setsumei,cid=:cid WHERE sid=:sid;');
				$sql->bindValue(':setsumei',$setsumei);
			}else{
				$sql = $db->prepare('UPDATE shouhin SET (sname=:sname,kakaku=:kakaku,cid=:cid);');
			}
			$sql->bindValue(':sid',$sid);
			$sql->bindValue(':sname',$sname);
			$sql->bindValue(':kakaku',$kakaku);
			$sql->bindValue(':cid',$cid);

			if( $sql->execute() ){

				//　商品情報が登録されれば画像をアップロード
				$sql = $db->prepare('SELECT * FROM shouhin WHERE sname=:sname;');
				$sql->bindValue(':sname',$sname);
				$sql->execute();
				$data = $sql->fetch();

				echo '<h3>商品情報を更新しました</h3><br>';
				echo '商品ID：' . $data['sid'] . '<br>';
				echo '商品名：' . htmlentities( $data['sname'], ENT_QUOTES, "UTF-8" ) . '<br>';
				echo '価格：' . $data['kakaku'] . '<br>';

		    $tempfile = $_FILES['fname']['tmp_name'];
		    $filename = "../img/" . $data['sid'] . ".jpg";

			  if (is_uploaded_file($tempfile)) {
			    if ( move_uploaded_file($tempfile , $filename )) {
			      echo '画像：再アップロード済<br>';
			    }else {
			      echo "ファイルをアップロードできません。" . '<br>';
			    }
			  }else {
		      echo '画像：再アップロードなし' . '<br>';
			  }
			}else{
			  header('Location: goods_edit.php?'.'sid='.$sid.'&err=2');
			  exit;
			}

			echo '<p><a href="goods_main.php">商品一覧に戻る</a></p>';

		}
	?>


</body>
</html>
