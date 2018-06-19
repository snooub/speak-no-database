<?php include 'func.php' ?>
<?php

if(isset($_POST['submit'])){

	// Nhận mảng
	extract($_POST);

	// Kiểm tra lỗi
	if(!($name)){
		$error = 'Chưa nhập nội dung.';
	}

	// Chèn dữ liệu
	if(!isset($error)){
		$name = slug($name);
		$Fname = 'data/site/' . $name . '.txt';
		$myfile = fopen($Fname, 'w');
		header('Location: site.php?name=' . $name);
	}

}

?>
<title>Speak</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
</style>

<pre><a href="/list.php">List</a> | <a href="/bookmark.php">Bookmark</a> | <a href="/multi.php">Multi</a></pre>

<hr>

<?php

// kiểm tra lỗi
if(isset($error)){
	echo '<p>'.$error.'</p>';
}

?>

<p>
	<form action="index.php" method="post">
	<input type="text" name="name">
	<input type="submit" name="submit" value="Thêm site">
	</form>
</p>

<?php

$fileList = glob('data/site/*.txt'); //Fetch all files.
$fileList = array_combine($fileList, array_map("filemtime", $fileList)); //Grab the filetime for each file
arsort($fileList); //Sort high to low
foreach ($fileList as $filename => $value) {
	//Use the is_file function to make sure that it is not a directory.
	if(is_file($filename)){
		$filename = str_replace(array('data/site/', '.txt'), '', $filename);
		?>
		<pre><a href="site.php?name=<?php echo $filename ?>"><?php echo $filename ?></a></pre>
	<?php }
}

?>