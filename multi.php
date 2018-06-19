<?php include 'func.php' ?>
<?php

$HOME = 'http://fivegins-fivegins.1d35.starter-us-east-1.openshiftapps.com';

//echo curl_multi($array);

if (isset($_GET['link'])){
	$link = $_GET['link'];
	$s = $_GET['s'];
	$e = $_GET['e']+1;

	// lay tu 1 den 2
	preg_match('#\['.$s.'\](.*?)\['.$e.'\]#is', curl($link), $links);

	// lay link tu 1 den 2
	preg_match_all('#</a> <a href="(.*?)"#is', $links[1], $rows);

	$urls = array();
	foreach ($rows[1] as $e) {
		$urls[] = $HOME . trim($e);
	}

	$content = multi_curl($urls);
	$content = preg_replace('#⊙(.*?)➥#is', '…<br>…<br>…<br>', $content);

	echo $content;

}else{ ?>
<title>Multi</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
	#copy {
		margin-bottom: 25px;
	}
	.btn {
		display: inline-block;
		padding: 15px 25px;
		font-size: 24px;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		outline: none;
		color: #fff;
		background-color: #4CAF50;
		border: none;
		border-radius: 15px;
		box-shadow: 0 9px #999;
	}

	.btn:hover {background-color: #3e8e41}

	.btn:active {
		background-color: #3e8e41;
		box-shadow: 0 5px #666;
		transform: translateY(4px);
	}
</style>

<form action="multi.php#copy" method="post">
	<p>
		<select name="link">
		<?php

		$fileList = glob("{truyencv/saves/*.html,tangthuvien/saves/*.html,truyenfull/saves/*.html}", GLOB_BRACE);

		foreach($fileList as $filename)
		{
			$name = str_replace(array('truyencv/saves/', 'tangthuvien/saves/', 'truyenfull/saves/', '.html', '-'), array('TCV ▸ ', 'TTV ▸ ', 'TF ▸ ', '', ' '), $filename);

			if($filename == $_POST['link'])
			{
				echo '<option value="'.$filename.'" selected>'.$name.'</option>';
			}
			else
			{
				echo '<option value="'.$filename.'">'.$name.'</option>';
			}
		}

		?>
		</select>
	</p>
	<p><input type="number" name="s" value="<?= $_POST['s']; ?>"></p>
	<p><input type="number" name="e" value="<?= $_POST['e']; ?>"></p>
	<input class="btn" type="submit" value="Get" />
</form>

<?php

	if(!empty($_POST['link'] && $_POST['s'] && $_POST['e'])){
		echo '<a href="' . $HOME . '/multi.php?link=' . $HOME . '/' . $_POST['link'] . '&s=' . $_POST['s'] . '&e=' . $_POST['e'] . '">' . $_POST['link'] . '&s=' . $_POST['s'] . '&e=' . $_POST['e'] . '</a>';
		echo "<hr>\n";
		echo '<button class="btn" data-clipboard-text="' . $HOME . '/multi.php?link=' . $HOME . '/' . $_POST['link'] . '&s=' . $_POST['s'] . '&e=' . $_POST['e'] . '">Copy</button><div id="copy"></div>';
	}
} /*end if*/ ?>

<script src="/clipboard.min.js"></script>
<script>
var clipboard = new ClipboardJS('.btn');

clipboard.on('success', function(e) {
	console.log(e);
});

clipboard.on('error', function(e) {
	console.log(e);
});
</script>
