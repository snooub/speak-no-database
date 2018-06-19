<?php include '../func.php' ?>
<?php

if (isset($_GET['link'])){

	$link = $_GET['link'];

	// title
	preg_match('#<title>(.*?)</title>#is', curl($link), $title);

	// slug
	preg_match('#doc-truyen/([a-z0-9-]+)"#is', curl($link), $slug);

	// get id
	preg_match('#value="([0-9]{1,10})"#is', curl($link), $id);

	// get danh sach chuong
	$page = curl('https://truyen.tangthuvien.vn/story/chapters?story_id=' . $id[1]);


	preg_match_all('#href="(.*?)"(.*?)title="(.*?)"#is', $page, $pages);

	/*foreach($pages[1] as $index => $value) {
		$url = 'single.php?link=' . trim($pages[1][$index]);
		$name = trim($pages[3][$index]);

		echo '<a href="' . $url . '">' . $name . '</a>';
		echo "<hr />\n";
	}
	*/

	// save start
	ob_start();

	echo "<title>" . $title[1] . "</title>\n";
	echo "<meta charset='UTF-8'>\n";
	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
	echo "<style>a{text-decoration: none;}</style>\n";

	for ($i = 0; $i < count($pages[1]); $i++) {
		echo '<a href="/bookmark.php?title=[TTV]' . trim($title[1]) . ' ➧ ' . trim($pages[3][$i]) . '"><font color="black">[' . ($i+1) . ']</font></a> <a href="/tangthuvien/tangthuvien.php?name=' . $slug[1] . '&link=' . trim($pages[1][$i]) . '">' . trim($pages[3][$i]) . '</a>';
		echo "<hr />\n";
	}

	// save end html
	file_put_contents('saves/' . $slug[1] . '.html', ob_get_contents());

	header('Location: saves/' . $slug[1] . '.html');

}else{ ?>

<title>Save</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
</style>
<form action="save.php" method="get">
	<input type="text" name="link" style="width:80%;">
	<input type="submit" value="Save" />
</form>

<?php } /*end if*/