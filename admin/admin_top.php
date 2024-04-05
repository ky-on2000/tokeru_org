<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION["login"]) === false) {
	print "ログインしていません。<br><br>";
	print "<a href='set_login.php'>ログイン画面へ</a>";
	exit();
}

require_once("../dbconnect.php");

$dbh = new PDO($dsn, $user, $password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT title FROM blog WHERE 1";
$stmt = $dbh -> prepare($sql);
$stmt -> execute();

while(true) {
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
	if(empty($rec["title"]) === true) {
		break;
	}
	$title[] = $rec["title"];
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow">
	<title>管理画面</title>
</head>

<body>
	<h1>管理画面</h1>
	<h2>記事投稿</h2>
	<p><a href="../post.php">新規記事作成</a></p>
	<h2>画像管理</h2>
	<p><a href="../image_display.php">画像表示</a></p>
	<p><a href="../image_upload.php">画像アップロード</a></p>
	<h2>ログアウト</h2>
	<p><a href="logout.php">ログアウト</a></p>
	<h2>記事一覧</h2>
	<?php
	if(isset($title) === true) {
		$sql = "SELECT id, title, content FROM blog ORDER BY id DESC";
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();
	
		while(true) {
			$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
			if(empty($rec["title"]) === true) {
				break;
			}
			print "<div>";
			print "<a href='../modify.php?id=".$rec['id']."'>";
			print strip_tags($rec["title"]);
			print "</a>";  
			print "</div>";
		}
	} else {
		print "<br><br>";
		print "記事はありません。";
	}
	
	$dbh = null;
	?>
	<p>準備中</p>
</body>
</html>
