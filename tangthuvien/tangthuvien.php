<?php

include '../func.php';
$link = $_GET['link'];
$name = $_GET['name'];
$fileTXT = '../data/site/' . $name . '.txt';

// loi neu file khong ton tai
if(!is_file($fileTXT)){
	echo 'error';
	exit();
}

?>
<?php

/* GET */
$c = curl($_GET['link']);

/*tieu de*/
preg_match("/<title>(.*?)<\/title>/is", $c, $title_match);
$title_match[1] = str_replace(array('[Dịch]', '- Sưu tầm'), '', $title_match[1]);
$title = explode(" - ", $title_match[1]);


/*noi dung*/
//loc html
$c = preg_replace('#(.*)<div class="box-chap box-chap-[0-9]{1,10}">(.*?)<div class="box-adv(.*)#is', '$2', $c);

$c = preg_replace('/  +/', ' ', $c);
$c = preg_replace('/\t/', '', $c);
$c = preg_replace('/\n/', '<br />', $c);
$c = preg_replace('/<br\s*\/?>(?:\s*<br\s*\/?>)+/', '<br /><br />', $c);
$c = preg_replace('/-(.)/', '- $1', $c);

//fix func
$c = filter(text($c));

$c = preg_replace('/>\s?\.\.\.\s?</', '>•••<', $c);

$c = str_replace(array('&quot;', '&lsquo;', '&rsquo;', '&ldquo;', '&rdquo;', '“', '”'), '"', $c);
$c = str_replace('"..."', '"Lặng!"', $c);

//$c = str_replace(array('-', '+', '@', '*', '&', '{', '}', '|', '\\', '/', '~'), '', $c);
//$c = str_replace(array('(', ')'), array('〈', '〉'), $c);
$c = preg_replace('/\([0-9]{1,2}\)/', '', $c);


$c = preg_replace('/\.{1,3},?\s?("|\')\.?,?!?\??\s?</', '…$1<', $c);
$c = preg_replace('/\?,?\s?("|\')\.?,?!?\??\s?</', 'ʔ$1<', $c);
$c = preg_replace('/\!,?\s?("|\')\.?,?!?\??\s?</', 'ǃ$1<', $c);

$c = preg_replace('/(\?|\.|!|,|ʔ|ǃ|…)(\?|\.|!|,|ʔ|ǃ|…)\"\s?</', '$2"<', $c);
$c = preg_replace('/(\.|\?|!)("|\')\.?,?!?/', '$1$2', $c);
$c = preg_replace('/\s"\s</', '"<', $c);

$c = preg_replace('/;\s?"\s?</', '"<', $c);
$c = preg_replace('/" ?"/', '', $c);

//$c = preg_replace('/(\w)\.\.\.(\w)/', '$1 $2', $c);
$c = preg_replace('/([0-9]{1,3}),?\s?([0-9]{3})/', '$1$2', $c);
$c = preg_replace('/([0-9]{1,2})\s?~\s?([0-9]{1,2})/', '$1 - $2', $c);


//thay doi noi dung

foreach(file($fileTXT) as $line) {
	$lines = explode('❤', $line);
	$s = str_replace("\r\n", "", $lines[0]);
	$r = str_replace("\r\n", "", $lines[1]);
	$c = preg_replace('#'.$s.'#is', $r, $c);
}


/* Show c */
if(isset($_GET['str'])) {
	echo mb_strlen($c, 'UTF-8');
	exit;
}


/* Show c */
if(isset($_GET['str'])) {
	echo mb_strlen($c, 'UTF-8');
	exit;
}

$title[1] = preg_replace('/Chương 0([1-9]{1})/', 'Chương $1', $title[1]);
echo '<title>'.$title_match[1].'</title>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo filter(text($title[0]));
echo '<br>➥<br>';
echo filter(text($title[1]));
echo '<br>➥<br>➥<br><br>';
echo strip_tags($c, '<br>');
echo '<br>⊙⊙';