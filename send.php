<?php
try {

	require_once("dbconnect.php");
	$PDO = new PDO($dsn, $user, $password); //PDOでMySQLのデータベースに接続
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

	$title = $_POST['title'];
	$content = $_POST['content'];
	$status = $_POST['status'];
	$content = str_replace('<div>', '<p>', $_POST['content']);
	$content = str_replace('</div>', '</p>', $content);
	$content = str_replace('<br>', '</p><p>', $content);
	$date = date("Y-m-d");
	$tag = explode(',',$_POST['tag'],200);

	$sql = "INSERT INTO blog (title, content, date, status) VALUES (:title, :content, :date, :status)"; // テーブルに登録するINSERT INTO文を変数に格納　VALUESはプレースフォルダーで空の値を入れとく
	$stmt = $PDO->prepare($sql); //値が空のままSQL文をセット
	$params = array(':title' => $title, ':content' => $content, ':date' => $date, ':status' => $status); // 挿入する値を配列に格納
	$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	
	$id = $PDO -> lastInsertId();

	//タグの設定
	$sql = "INSERT INTO tag (id, tag) VALUES (:id, :tag)";
	$stmt = $PDO->prepare($sql);
	
	for($i = 0; isset($tag[$i]); $i++) {
		echo "<p>tag: " . $tag[$i] . "</p>";
		$params2 = array(':id' => $id, ':tag' => $tag[$i]);
		$stmt->execute($params2);
	}

	// 登録内容確認・メッセージ
	echo "<p>title: " . $title . "</p>";
	echo "<p>content: " . $content . "</p>";
	echo '<p>上記の内容をデータベースへ登録しました。</p>';
} catch (PDOException $e) {
	exit('データベースに接続できませんでした。' . $e->getMessage());
}
?>
