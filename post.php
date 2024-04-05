<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow">
	<link rel="stylesheet" href="style.css">
	<link rel="icon" href="/images/favicon.ico">
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js
"></script>
	<script src="https://unpkg.com/turndown/dist/turndown.js"></script>
	<script>
		$(document).ready(function(){
					var turndownService = new TurndownService()
                     $("textarea").keyup(function(){
                           MDtoHTML();
                     });
					 $('#HTML2MD').on('click', function() {
						document.getElementById("markdown_input").innerHTML = turndownService.turndown(document.getElementById("content_input").value);
					});
             });

             function MDtoHTML(){
				 document.getElementById("content_input").innerHTML =
                 marked.parse(document.getElementById("markdown_input").value);
             }
	</script>
</head>
<body>
	<h1>新規記事投稿画面</h1>
	<form method="POST" name="post" action="send.php">
	<form>
		<h2>タイトル</h2>
		<input type="text" name="title" class="title_input">
		<h2>本文</h2>
		<div class="MD_HTML">
			<div class="MD">
				<h3>Markdown</h3>
				<textarea name="MD" id="markdown_input" rows="50" cols="50"></textarea>
			</div>
		
			<div class="HTML">
				<h3>HTML</h3>
				<button id="HTML2MD" type="button">HTML to Markdown</button>
				<textarea name="content" id="content_input" rows="50" cols="50"></textarea>
			</div>
		</div>
		<br><br>
		<div class="tag_submit">
			<h2>タグ　※,(カンマ)で区切ること</h2>
			<textarea name="tag" class="tag_input"></textarea>
			<p><input type="radio" name="status" value="0">下書き
			<input type="radio" name="status" value="1">公開</p>
			<p><input type="submit" value="登録"></p>
		</div>
	</form>
	<!--</form>-->
	
</body>
</html>
