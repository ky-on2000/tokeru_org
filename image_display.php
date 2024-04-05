<?php
require_once("dbconnect.php");
try {
    $dbh = new PDO($dsn, $user, $password);
	$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//$sql = "SELECT image_id FROM images WHERE 1";
	//$stmt = $dbh -> prepare($sql);
	//$stmt -> execute();

	//while(true) {
		//$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
		//if(empty($rec["image_id"]) === true) {
			//break;
		//}
		//$image_id[] = $rec["image_id"];
	//}
	//if(isset($image_id) === true) {
		$sql = "SELECT image_id, date, filename FROM images ORDER BY image_id";
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();
		while(true) {
			$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
			if(empty($rec["image_id"]) === true) {
				break;
			}
			print '<p><time>'.$rec["date"].'</time></p>';
			print '<p>images/'.$rec["filename"].'</p>';
			print '<p><img src="images/'.$rec["filename"].'" width="300" height="300"></p>';
		}
	//} else {
	//	print "<br><br>";
	//	print "画像はありません。";
	//}
	$dbh = null;

}catch(Exception $e) {
	print "異常";
	exit();
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
</head>
<body>
<a href="image_upload.php">画像アップロード</a></html>
</body>
</html>