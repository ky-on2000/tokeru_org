<!DOCTYPE html>
<html lang="ja">
	<head>
		<!--<title>-とけろぐ</title>-->
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="icon" href="/images/favicon.ico">
	</head>
	<body>
		<header><a href="index.php" class="title"><h1>とけろぐ</h1></a></header>
		<section class="outer">
<?php
    try {
	$id = $_GET["id"];
                
	require_once("dbconnect.php");
	$dbh = new pdo($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	$sql = "SELECT title, content, date FROM blog WHERE id=$id";
	$stmt = $dbh -> prepare($sql);
	$stmt -> execute();
	$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        
	print '<h2>'.$rec["title"].'</h2>';

	//tag
 	$sql = "SELECT tag FROM tag WHERE id=$id";
	$stmt = $dbh -> prepare($sql);
 	$stmt -> execute();
 	$tagResults = $stmt -> fetchAll(PDO::FETCH_COLUMN);

	print "<ul class='tag'>";
	
	$cgr_array = array();
	foreach ($tagResults as $row) {
		print "<li class='tag'><p class='tag'><a class='tag' href='tag.php?tag=\"".$row."\"'>";
		print $row;
		print "</a></p></li>";
	}
	print "</ul>";
	print "<p class='time'><time>".$rec["date"]."</time></p>";
	print '<section class="innner">'.$rec["content"];
    }
    catch(Exception $e) {
        print "異常";
        exit();
    }
?>
			</section>
		</section>
	</body>
</html>

