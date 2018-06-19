<?php include '../func.php' ?>
<?php

if (isset($_GET['link'])){

	$link = $_GET['link'];
	$html = curl($link);

	// title
	preg_match('#<title>(.*?)</title>#is', $html, $title);

	// slug
	preg_match('#href="http://truyenfull.vn/([a-z0-9-]+)/"#is', $html, $slug);

	//tong
	if(!preg_match('#<ul class="pagination pagination-sm">#is', $html)){
		$last = '1';
	}else{
		if(preg_match('#Trang ([0-9]{1,3})">Cuối#is', $html)){
			preg_match('#Trang ([0-9]{1,3})">Cuối#is', $html, $tong);
			$last = $tong[1];
		}else{
			preg_match('#(.*)>([0-9]{1,3})</a></li><li>#is', $html, $tong);
			$last = $tong[2];
		}
	}


	// get multi pages
	for($i = 1; $i <= $last; $i++) $links[] = $link . 'trang-'.$i.'/';
	$page = multi_curl($links);

	$page = preg_replace('#(.*?)<h2>Danh sách chương</h2>(.*?)<h2>Bình luận truyện</h2>(.*?)#is', '$2', $page);
	preg_match_all('#<li><span class="glyphicon glyphicon-certificate"></span>(.*?)href="(.*?)"(.*?)</span></span>(.*?)</a></li>#is', $page, $pages);

	// save start
	ob_start();

	echo "<title>" . $title[1] . "</title>\n";
	echo "<meta charset='UTF-8'>\n";
	echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
	echo "<style>a{text-decoration: none;}</style>\n";

	for ($i = 0; $i < count($pages[2]); $i++) {
		echo '<a href="/bookmark.php?title=[TF]' . trim($title[1]) . ' ➧ Chương ' . trim($pages[4][$i]) . '"><font color="black">[' . ($i+1) . ']</font></a> <a href="/truyenfull/truyenfull.php?name=' . $slug[1] . '&link=' . trim($pages[2][$i]) . '">Chương ' . trim($pages[4][$i]) . '</a>';
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