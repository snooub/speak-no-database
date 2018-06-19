<title>List</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
	a {text-decoration: none;}
</style>

<!-- xoa -->
<script language="JavaScript" type="text/javascript">
    function unlink(sitename)
        {
            if (confirm("Bạn có muốn xóa '" + sitename + "'"))
        {
            window.location.href = '?unlink=' + sitename;
        }
    }
</script>

<?php

// unlink
if (isset($_GET['unlink'])) {
	unlink($_GET['unlink']);
	header('Location: list.php');
	exit();
}
?>

<h3><a href="/truyencv"><font color="black">Truyện CV</font></a></h3>
<?php
$fileList = glob('truyencv/saves/*.html');
foreach($fileList as $filename){
    if(is_file($filename)){ ?>
        <a href="javascript:unlink('<?php echo $filename ?>')"><font color="red">✘</font></a> <a href="<?php echo $filename ?>"><?php echo ucwords(str_replace(array('truyencv/saves/', '.html', '-'), array('', '', ' '), $filename)) ?></a><br>
    <?php }
} ?>
<hr>

<h3><a href="/tangthuvien"><font color="black">Tàng thư viện</font></a></h3>
<?php
$fileList = glob('tangthuvien/saves/*.html');
foreach($fileList as $filename){
    if(is_file($filename)){ ?>
        <a href="javascript:unlink('<?php echo $filename ?>')"><font color="red">✘</font></a> <a href="<?php echo $filename ?>"><?php echo ucwords(str_replace(array('tangthuvien/saves/', '.html', '-'), array('', '', ' '), $filename)) ?></a><br>
    <?php }
} ?>
<hr>

<h3><a href="/truyenfull"><font color="black">Truyện full</font></a></h3>
<?php
$fileList = glob('truyenfull/saves/*.html');
foreach($fileList as $filename){
    if(is_file($filename)){ ?>
        <a href="javascript:unlink('<?php echo $filename ?>')"><font color="red">✘</font></a> <a href="<?php echo $filename ?>"><?php echo ucwords(str_replace(array('truyenfull/saves/', '.html', '-'), array('', '', ' '), $filename)) ?></a><br>
    <?php }
} ?>
<hr>

