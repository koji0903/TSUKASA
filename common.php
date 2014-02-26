<?php 
// データベースの基本処理
function db()
{
	$db = new PDO("mysql:dbname=tsukasadb", "root", "root");
	$db->query("SET NAMES utf8;");
	return $db;
}
// GIDの取得関数
function getGID($uid)
{
	$db = db();
	$sql = $db->prepare('SELECT gid FROM user WHERE uid = ?;');
	$sql->bindValue(1,$uid);
	if ( $sql->execute() ){
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		return $data['gid'];
	}
	else
	{
		// データベースアクセス失敗
	}
}
// ヘッダーの表示関数
function disp_header()
{
	if( isset($_SESSION['UID']) ){
		$gid = getGID($_SESSION['UID']);
		if($gid == 1){
			echo '<p><a href="./sh/cart.php">', "カート", '</a></p><br>';
			echo '<p><a href="./top.php">商品一覧</a></p><br>';
			echo '<p><a href="./sh/mypage.php">マイページ</a></p><br>';
			echo '<p><a href="./logout.php">ログアウト</a></p><br>';
		}
		else{
			echo '<p><a href="./maintenance.php">管理者ページ</a></p><br>';
			echo '<p><a href="./logout.php">ログアウト</a></p><br>';
		}
	}
	else{
		echo '<p><a href="./login.php">ログイン</a></p>';
	}
}
// ヘッダーの表示関数
function disp_header2()
{
	if( isset($_SESSION['UID']) ){
		$gid = getGID($_SESSION['UID']);
		if($gid == 1){
			echo '<p><a href="../sh/cart.php">', "カート", '</a></p><br>';
			echo '<p><a href="../top.php">商品一覧</a></p><br>';
			echo '<p><a href="../sh/mypage.php">マイページ</a></p><br>';
			echo '<p><a href="../logout.php">ログアウト</a></p><br>';
		}
		else{
			echo '<p><a href="../maintenance.php">管理者ページ</a></p><br>';
			echo '<p><a href="../logout.php">ログアウト</a></p><br>';
		}
	}
	else{
		echo '<p><a href="../login.php">ログイン</a></p>';
	}
}

?>
