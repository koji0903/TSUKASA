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
	echo "<div id=\"navi\">";
	echo '<ul>';
	if( isset($_SESSION['UID']) ){
		$gid = getGID($_SESSION['UID']);
		if($gid == 1){
			echo '<li><a href="./sh/cart.php">', "カート", '</a></li>';
			echo '<li><a href="./top.php">商品一覧</a></li>';
			echo '<li><a href="./sh/mypage.php">マイページ</a></li>';
			echo '<li><a href="./logout.php">ログアウト</a></li>';
		}
		else{
			echo '<li><a href="./maintenance.php">管理者ページ</a></li>';
			echo '<li><a href="./logout.php">ログアウト</a></li>';
		}
	}
	else{
		echo '<li><a href="./login.php">ログイン</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	echo "<br>";

}
// ヘッダーの表示関数
function disp_header2()
{
	echo "<div id=\"navi\">";
	echo '<ul>';
	if( isset($_SESSION['UID']) ){
		$gid = getGID($_SESSION['UID']);
		if($gid == 1){
			echo '<li><a href="../sh/cart.php">', "カート", '</a></li>';
			echo '<li><a href="../top.php">商品一覧</a></li>';
			echo '<li><a href="../sh/mypage.php">マイページ</a></li>';
			echo '<li><a href="../logout.php">ログアウト</a></li>';
		}
		else{
			echo '<li><a href="../maintenance.php">管理者ページ</a></li>';
			echo '<li><a href="../logout.php">ログアウト</a></li>';
		}
	}
	else{
		echo '<li><a href="../login.php">ログイン</a></li';
	}
	echo '</ul>';
	echo '</div>';
	echo "<br>";
}

?>
