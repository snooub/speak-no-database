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

$html = curl($link);

// tit[2]
preg_match('#<a class="truyen-title"(.*?)>(.*?)</a>#is', $html, $tit);

// chap [2]
preg_match('#<a class="chapter-title"(.*?)<span>(.*?)</a>#is', $html, $chap);

// con [1]
preg_match('#<div class="chapter-c">(.*?)</div><div class="hidden-xs#is', $html, $con);


/*noi dung*/
//loc html
$c = $con[1];

$c = strip_tags($c, '<br>');

$c = preg_replace('/  +/', ' ', $c);
$c = preg_replace('/\t/', '', $c);
$c = preg_replace('/\n/', '<br />', $c);
$c = preg_replace('/<br\s*\/?>(?:\s*<br\s*\/?>)+/', '<br /><br />', $c);

//fix func
$c = filter(text($c));

$c = preg_replace('/>\s?\.\.\.\s?</', '>•••<', $c);

$c = str_replace(array('&quot;', '&lsquo;', '&rsquo;', '&ldquo;', '&rdquo;'), '"', $c);
$c = str_replace('"..."', '"Lặng!"', $c);

//$c = str_replace(array('-', '+', '@', '*', '&', '{', '}', '|', '\\', '/', '~'), '', $c);
//$c = str_replace(array('(', ')'), array('〈', '〉'), $c);
$c = preg_replace('/\([0-9]{1,2}\)/', '', $c);


$c = preg_replace('/\.{1,3},?\s?("|\')\.?,?!?\??\s?</', '…$1<', $c);
$c = preg_replace('/\?,?\s?("|\')\.?,?!?\??\s?</', 'ʔ$1<', $c);
$c = preg_replace('/\!,?\s?("|\')\.?,?!?\??\s?</', 'ǃ$1<', $c);
// loc lan 2
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

echo '<title>' . trim($tit[2]) . ' - ' . strip_tags(trim($chap[2])) . '</title>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo filter(text(trim($tit[2])));
echo '<br>➥<br>';
echo filter(text(strip_tags($chap[2])));
echo '<br>➥<br>➥<br><br>';
echo filter($c);
echo '<br>⊙⊙';