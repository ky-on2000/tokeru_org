<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>トップページ - とけろぐ</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="/images/favicon.ico">
	</head>
	<body>
		<header><a href="index.php" class="title"><h1>とけろぐ</h1></a></header>
		<section class="outer">
			<h2>タグ一覧</h2>
			<section class="inner">	
				<ul class='inner'>
<?php
try {

	if(empty($_GET["tag"]) === true) {
		// ここにタグクラウド的なやつをおけばいいのでは？ 
	} else {
		//sanitize
		$tag = $_GET["tag"];
	}
	
	require_once("dbconnect.php");
	$dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT id FROM tag WHERE tag=$tag";
	$stmt = $dbh -> prepare($sql);
	$stmt -> execute();
	$idResults = $stmt -> fetchAll(PDO::FETCH_COLUMN);
	
	
	foreach ($idResults as $row) {
		$sql = "SELECT title, date, status FROM blog WHERE id=$row";
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();
		$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
		if($rec["status"] == 1){
			print "<li class='top'>";
			print "<p class='top_content_up'><time>";
			print $rec["date"]."</time></p>";
			print "<p class='top_content_down'><a class='top_link' href=page.php?id=".$row.">";
			print $rec["title"]."</a></p></li>";
		}
		$rec = null;
	}	
	$dbh = null;

}
catch(Exception $e) {
	print "異常";
	exit();
}

?>
				</ul>
			</section>
		</section>
	</body>
</html>

