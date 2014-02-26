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

    $db = db();

    $sql = $db->prepare('SELECT * FROM shouhin WHERE sid=:sid');
    $sql->bindValue(':sid',$sid);
    $sql->execute();
    $data = $sql->fetch();

    $sid = $data['sid'];
    $sname = $data['sname'];
    $kakaku = $data['kakaku'];
    $cid = $data['cid'];
    $setsumei = $data['setsumei'];

    // カテゴリリストの習得
    $sql = $db->prepare('SELECT * FROM category');
    $sql->execute();
    $call = $sql->fetchAll();
    $sql=null;

		// エラーメッセージ出力
	  if( isset( $_GET['err']) ){
	  		$err = $_GET['err'];
	  		if( $err==1 ){
	  			echo '<h3>すでに登録されている商品です。</h3>';
	  		}else if( $err==2 ){
	  			echo '<h3>商品情報更新時にエラーが発生しました</h3>';
	  		}
		}
	?>

  <p>
    <p>　■　製品情報を選択</p>
    <form action="goods_edit2.php" method="post" enctype="multipart/form-data">
    	<input type="hidden" name="sid" value=<?php echo $sid ?>>
      商品名 <input type="text" name="sname" value=<?php echo htmlentities( $sname, ENT_QUOTES, "UTF-8" ) ?>><br>
      価格 <input type="text" name="kakaku" value=<?php echo $kakaku ?>><br>
      カテゴリ <select name="cid">
      <?php
        foreach( $call as $data ){
        	if( $data['cid'] == $cid ){
	          echo '<option value="' . $data['cid'] . '"selected >' . htmlentities( $data['cname'], ENT_QUOTES, "UTF-8" ) . '</option>';
        	}else{
	          echo '<option value="' . $data['cid'] . '">' . htmlentities( $data['cname'], ENT_QUOTES, "UTF-8" ) . '</option>';
        	}
        }
      ?>
      </select><br>
      説明
      <br><textarea cols="30" rows="20" name="setsumei">
        <?php echo htmlentities( htmlentities( $setsumei, ENT_QUOTES, "UTF-8" ), ENT_QUOTES, "UTF-8" ) ?>
      </textarea><br>
      <p>　■　画像データ(jpg)</p>

      <?php
      if( file_exists('../img/' . $sid . '.jpg')){
      	echo '<img src="../img/' . $sid . '.jpg" alt="' . $sname . '"><br>';
      }else{
      	echo '<p>no picture</p>';
      }
      ?>

		  <input type="file" name="fname"><br><br>
      <input type="submit" value="商品情報更新"><br>
    </form>
  </p>
  <p><a href="goods_main.php"><button>キャンセル</button></a></p>


</body>
</html>
