<?php

include 'func.php';
$name = $_GET['name'];
$fileTXT = 'data/site/' . $name . '.txt';

// loi neu file khong ton tai
if(!is_file($fileTXT)){
	echo 'error';
	exit();
}

?>
<?php

if(isset($_POST['submit'])){

	// Nhận mảng
	extract($_POST);

	// Kiểm tra lỗi
	if(!($s)){
		$error = 'Chưa nhập nội dung.';
	}

	if($r == ''){
		$s = $s . "❤\r\n";
	}else{
		$s = $s . '❤';
	}

	if($r != ''){
		$r = $r . "\r\n";
	}

	// Chèn dữ liệu
	if(!isset($error)){

		$lines = file($fileTXT);
		$fopen = fopen($fileTXT, 'w+');
		fwrite( $fopen, $s);
		fwrite( $fopen, $r);
		foreach ($lines as $line) { fwrite( $fopen, $line); }
		fclose($fopen);
		header('Location: ?name=' . $name);

	}

}

?>
<?php

if(isset($_GET['xoa_line'])){
	$deleteLine = htmlspecialchars_decode($_GET['xoa_line'], ENT_NOQUOTES);
	deleteLineInFile($fileTXT, $deleteLine); // Func.php deleteLineInFile

	header('Location: ?name=' . $name);
	exit;
}

?>
<?php

if(isset($_GET['xoa_code'])){
	$fh = fopen($fileTXT, 'w');
	fclose($fh);

	header('Location: ?name=' . $name);
	exit;
}

?>
<?php

if(isset($_GET['xoa_site'])){
	unlink($fileTXT);

	header('Location: index.php');
	exit;
}

?>
<title><?php echo $name ?> [site]</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
</style>

<!-- xoa line -->
<script language="JavaScript" type="text/javascript">
	function xoa_line(fileline, sitename)
		{
			if (confirm("Bạn có muốn xóa line '" + fileline + "'"))
		{
			window.location.href = '?name=' + sitename + '&xoa_line=' + fileline;
		}
	}
</script>

<!-- xoa code -->
<script language="JavaScript" type="text/javascript">
	function xoa_code(sitename)
		{
			if (confirm("Bạn có muốn xóa code '" + sitename + "'"))
		{
			window.location.href = '?xoa_code&name=' + sitename;
		}
	}
</script>

<!-- xoa code -->
<script language="JavaScript" type="text/javascript">
	function xoa_site(sitename)
		{
			if (confirm("Bạn có muốn xóa site '" + sitename + "'"))
		{
			window.location.href = '?xoa_site&name=' + sitename;
		}
	}
</script>

<?php

// kiểm tra lỗi
if(isset($error)){
	echo '<p>'.$error.'</p>';
}

?>

<form action="?name=<?php echo $name ?>" method="post">
<textarea name="s" style="width:98%;"></textarea>
<textarea name="r" style="width:98%;"></textarea>
<input type="submit" name="submit" value="Replace">
</form>
<p>p/s: sử dụng preg_replace regex flags ##is, replace new line = \s</p>

<h3><?php echo $name ?></h3>
<a href="javascript:xoa_site('<?php echo $name ?>')">Xóa site</a> | <a href="javascript:xoa_code('<?php echo $name ?>')">Xóa code</a> | <a href="edit.php?name=<?php echo $name ?>">Sửa code</a>
<hr>

<?php

foreach(file($fileTXT) as $line) {
	$lines = explode('❤', $line);
	if($lines[1] == "\r\n" || $lines[1] == ""){
		$lines[1] = "null";
	}
	$r = str_replace(array(" ", "\r\n"), array("▂", ""), $lines[1]);
	$s = str_replace(array(" ", "\r\n"), array("▂", ""), $lines[0]);
	?>

	<pre><?php echo htmlspecialchars($s) ?> <font color="red">=></font> <?php echo htmlspecialchars($r) ?> <a href="javascript:xoa_line('<?php echo htmlspecialchars(str_replace("\r\n", "", $line)) ?>','<?php echo $name ?>')">xóa</a></pre>

<?php } ?>