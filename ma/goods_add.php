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
    $db = db();

    // カテゴリリストの習得
    $sql = $db->prepare('SELECT * FROM category');
    $sql->execute();
    $all = $sql->fetchAll();
    $sql=null;

		// エラーメッセージ出力
	  if( isset( $_GET['err']) ){
	  		$err = $_GET['err'];
	  		if( $err==1 ){
	  			echo '<h3>すでに登録されている商品です。</h3>';
	  		}else if( $err==2 ){
	  			echo '<h3>登録に失敗しました。</h3>';
	  		}
	  	}
	?>

  <p>
    <p>　■　製品情報を選択</p>
    <form action="goods_add2.php" method="post" enctype="multipart/form-data">
      商品名 <input type="text" name="sname"><br>
      価格 <input type="text" name="kakaku"><br>
      カテゴリ <select name="cid">
      <?php
        foreach( $all as $data ){
          echo '<option value="' . $data['cid'] . '">' . htmlentities( $data['cname'], ENT_QUOTES, "UTF-8" ) . '</option>';
        }
      ?>
      </select><br>
      説明
      <br><textarea cols="30" rows="20" name="setsumei"></textarea><br>
      <p>　■　画像データ(jpg)</p>
		  <input type="file" name="fname"><br><br>
      <input type="submit" value="OK"><br>
    </form>
  </p>
  <p><a href="goods_main.php"><button>キャンセル</button></a></p>



</body>
</html>
