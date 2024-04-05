<?php
require_once("dbconnect.php");
try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
if (isset($_POST['upload'])) {//送信ボタンが押された場合
    $image = uniqid(mt_rand().'_');//ファイル名をユニーク化
	print "test =".$image;
    $image .= ".".substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
    $file = "images/$image";
	$date = date("Y-m-d");
	$sql = "INSERT INTO images (date, filename) VALUES (:date, :filename)";
    $stmt = $dbh->prepare($sql); //値が空のままSQL文をセット
	$params = array(':date' => $date, ':filename' => $image); // 挿入する値を配列に格納
	if (!empty($_FILES['image']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
        move_uploaded_file($_FILES['image']['tmp_name'], './images/'.$image);//imagesディレクトリにファイル保存
        if (exif_imagetype($file)) {//画像ファイルかのチェック
            $message = '画像をアップロードしました';
            $stmt->execute($params);
        } else {
            $message = '画像ファイルではありません';
            }
        }
    }
?>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
</head>
<body>
<h1>画像アップロード</h1>
<a href="image_display.php">画像表示</a>
<?php if (isset($_POST['upload'])): ?>
    <p><?php echo $message; ?></p>
<?php else: ?>
    <form method="post" enctype="multipart/form-data">
        <p>アップロード画像</p>
        <input type="file" name="image">
        <input type="submit" name="upload" value="送信">
    </form>
<?php endif;?>
</body>
</html>