<?php

// nếu mẫu đã được gửi thì xử lý nó
if(isset($_POST['submit'])){

	// thu thập dữ liệu biểu mẫu
	extract($_POST);

	// Kiểm tra nội dung
	if($text ==''){
		$error[] = 'Chưa nhập.';
	}


	if (!preg_match('#truyencv.com/(.*?)/chuong#is', $text)){
		$error[] = 'Sai.';
	}

	if(!isset($error)){

		// slug
		preg_match('#truyencv.com/(.*?)/chuong#is', $text, $slug);

		// get url
		preg_match_all('#href="(.*?)"(.*?)>(.*?)<span#is', $text, $urls);
		$page = print_r(array_reverse($urls[0]), true);
		preg_match_all('#href="(.*?)"(.*?)>(.*?)<span#is', $page, $pages);

		// save start
		ob_start();

		echo "<title>" . $slug[1] . "</title>\n";
		echo "<meta charset='UTF-8'>\n";
		echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
		echo "<style>a{text-decoration: none;}</style>\n";

		for ($i = 0; $i < count($pages[1]); $i++) {
			echo '<a href="/bookmark.php?title=[TCV]' . str_replace('-', ' ', $slug[1]) . ' ➧ ' . trim($pages[3][$i]) . '"><font color="black">[' . ($i+1) . ']</font></a> <a href="/truyencv/truyencv.php?name=' . $slug[1] . '&link=' . trim($pages[1][$i]) . '">' . trim($pages[3][$i]) . '</a>';
			echo "<hr />\n";
		}

		// save end html
		file_put_contents('saves/' . $slug[1] . '.html', ob_get_contents());

		header('Location: saves/' . $slug[1] . '.html');

	}

}

// kiểm tra lỗi
if(isset($error)){
	foreach($error as $error){
		echo '<p>'.$error.'</p>';
	}
}

?>
<title>Save</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
</style>

<form action="save.php" method="post">
	<textarea name="text" style="width:98%; height: 80%;"></textarea>
	<input type="submit" name="submit" value="Save">
</form>