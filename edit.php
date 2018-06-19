<?php

$name = $_GET['name'];
$fileTXT = 'data/site/' . $name . '.txt';

// loi neu file khong ton tai
if(!is_file($fileTXT)){
	echo 'error';
	exit();
}

?>
<?php

if (isset($_POST['text']))
{
	// save the text contents
	file_put_contents($fileTXT, $_POST['text']);
	
	header('Location: site.php?name=' . $name);
	exit();
}

// read the textfile
$text = file_get_contents($fileTXT);

?>
<title><?php echo $name ?> [edit]</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
</style>

<!-- HTML form -->
<form action="?name=<?php echo $name ?>" method="post">
	<textarea name="text" style="width:98%; height: 80%;"><?php echo htmlspecialchars($text) ?></textarea>
	<input type="submit" value="Save">
</form>