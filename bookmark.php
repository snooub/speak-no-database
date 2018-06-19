<?php

include 'func.php';
$fileTXT = 'data/bookmark/bookmark.txt';

?>
<?php

if (isset($_GET['title'])){

    $title = $_GET['title'];

    if($title ==''){
        $error = 'error';
    }else{
        $lines = file($fileTXT);
        $fopen = fopen($fileTXT, "w+");
        fwrite( $fopen, "$title\r\n");
        foreach ($lines as $line) { fwrite( $fopen, "$line"); }
        fclose($fopen);
        header('Location: bookmark.php');
    }
}

?>
<?php

if(isset($_GET['xoa_line'])){
	$deleteLine = htmlspecialchars_decode($_GET['xoa_line'], ENT_NOQUOTES);
	deleteLineInFile($fileTXT, $deleteLine); // Func.php deleteLineInFile

	header('Location: bookmark.php');
	exit;
}

?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>Bookmark</title>

<style>
  a {
    text-decoration: none;
  }

</style>
<body>
<!-- xoa line -->
<script language="JavaScript" type="text/javascript">
	function xoa_line(fileline)
		{
			if (confirm("Bạn có muốn xóa line '" + fileline + "'"))
		{
			window.location.href = '?xoa_line=' + fileline;
		}
	}
</script>

<form action="bookmark.php" method="get">
    <textarea name="title" style="width:98%;"></textarea>
    <input type="submit" value="Viết" />
</form>

<?php echo $error; ?>
<?php

foreach(file($fileTXT) as $line) { ?>

    <p><a href="javascript:xoa_line('<?php echo htmlspecialchars(str_replace("\r\n", "", $line)) ?>')"><font color="red">✘</font></a> <?php echo htmlspecialchars(str_replace("\r\n", "", $line)) ?></p><hr>

<?php } ?>

</body>
</html>