<?php

// hàm get một trang
function curl($link) {
	// Tạo mới một cURL
	$ch = curl_init();

	// Cấu hình cho cURL
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 600);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Thực thi cURL
	$result = curl_exec($ch);

	// Ngắt cURL, giải phóng
	curl_close($ch);

	return $result;
}

// hàm get nhiều trang
function multi_curl($links) {
	$mh = curl_multi_init();
	foreach($links as $k => $link) {
		$ch[$k] = curl_init();
		curl_setopt($ch[$k], CURLOPT_URL, $link);
		curl_setopt($ch[$k], CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36');
		curl_setopt($ch[$k], CURLOPT_HEADER, 0);
		curl_setopt($ch[$k], CURLOPT_TIMEOUT, 0);
		curl_setopt($ch[$k], CURLOPT_RETURNTRANSFER, 1);
		curl_multi_add_handle($mh, $ch[$k]);
	}
	$running = null;
	do {
		curl_multi_exec($mh, $running);
	} while($running > 0);
	foreach($links as $k => $link) {
		$result[$k] = curl_multi_getcontent($ch[$k]);
		curl_multi_remove_handle($mh, $ch[$k]);
	}
	curl_multi_close($mh);
	return join('', $result);
}


//xu ly ky tu dac biet van ban
function filter($special) {

	//$special = str_replace(array('[', ']', '(', ')', '{', '}', '\\', '#', '*', '_', '=', '+', '|', '*', '~', '@', '^', ';'), '', $special);
	$special = preg_replace('/\s\s+/', ' ', $special);
	$special = preg_replace('/\,\,+/', ',', $special);
	$special = preg_replace('/\-\-+/', '-', $special);
	$special = preg_replace('/\:\:+/', ':', $special);
	$special = preg_replace('/\$\$+/', '$', $special);
	$special = preg_replace('/\%\%+/', '%', $special);
	$special = preg_replace('/\&\&+/', '&', $special);
	$special = preg_replace('/;;+/', ';', $special);
	$special = preg_replace('/\?\?+/', '?', $special);
	$special = preg_replace('/!!+/', '!', $special);
	$special = preg_replace('/\—\—+/', '—', $special);

	$special = preg_replace('/\.\s+\./', '..', $special);
	$special = preg_replace('/\.\s\./', '..', $special);
	$special = preg_replace('/\.\.+/', '...', $special);
	
	$special = preg_replace('/\*\s+\*/', '**', $special);
	$special = preg_replace('/\*\s\*/', '**', $special);
	$special = preg_replace('/\*\*+/', '***', $special);

	$special = preg_replace('/\s(,|\.|!|:|\?|;)/', '$1', $special);
	return $special;
}

function text($word) {
	$word = str_replace('Ria', 'dia', $word);
	$word = str_replace('ria', 'dia', $word);
	$word = str_replace('Sum', 'xum', $word);
	$word = str_replace('sum', 'xum', $word);
	$word = str_replace('Boa', 'Bo', $word);
	$word = str_replace('boa', 'bo', $word);
	$word = str_replace(' Mu ', ' Mư ', $word);
	$word = str_replace(' mu ', ' mư ', $word);
	$word = str_replace(' Go ', ' Gô ', $word);
	$word = str_replace(' go ', ' gô ', $word);
	$word = str_replace(' go,', ' gô,', $word);
	$word = str_replace(' go.', ' gô.', $word);
	$word = str_replace(' Ko ', ' Không ', $word);
	$word = str_replace(' ko ', ' không ', $word);
	$word = str_replace(' K ', ' Không ', $word);
	$word = str_replace(' k ', ' không ', $word);

	$word = str_replace('cmn', 'con mẹ nó', $word);
	$word = str_replace('Cmn', 'Con mẹ nó', $word);
	$word = str_replace('Kg', 'ki-lô-gam', $word);
	$word = str_replace('kg', 'ki-lô-gam', $word);
	$word = str_replace('Km', 'ki-lô-mét', $word);
	$word = str_replace('km', 'ki-lô-mét', $word);
	$word = str_replace('Cm', 'xen-ti-mét', $word);
	$word = str_replace('cm', 'xen-ti-mét', $word);
	$word = str_replace('Ml', 'Mi-li-lít', $word);
	$word = str_replace('ml', 'mi-li-lít', $word);
	$word = str_replace('vs', 'với', $word);
	$word = str_replace('level', 'cấp', $word);
	$word = str_replace('max', 'tối đa', $word);
	$word = str_replace('Max', 'Tối đa', $word);
	$word = str_replace('limit', 'giới hạn', $word);

	$word = str_replace('cảu', 'của', $word);
	$word = str_replace('nầy', 'này', $word);
	$word = str_replace('Oh', 'Ồ...', $word);
	$word = str_replace('oh', 'ồ...', $word);
	$word = str_replace('Uh', 'Ừ', $word);
	$word = str_replace('uh', 'ừ', $word);
	$word = str_replace('Ah', 'A...', $word);
	$word = str_replace('ah', 'a...', $word);
	$word = str_replace('Ha...a', 'Haha', $word);
	$word = str_replace('ha...a', 'haha', $word);

	$word = str_replace('Qủa', 'Quả', $word);
	$word = str_replace('qủa', 'quả', $word);
	$word = str_replace('Gía', 'Giá', $word);
	$word = str_replace('gía', 'giá', $word);
	$word = str_replace('uời', 'ười', $word);
	$word = str_replace('uớc', 'ước', $word);
	$word = str_replace('ửơ', 'ưở', $word);
	$word = str_replace('ứơ', 'ướ', $word);
	$word = str_replace('ừơ', 'ườ', $word);
	$word = str_replace('ựơ', 'ượ', $word);
	$word = str_replace('ưú', 'ứu', $word);
	$word = str_replace('uơ', 'ươ', $word);
	$word = str_replace('uợ', 'ượ', $word);
	$word = str_replace('uớ', 'ướ', $word);
	$word = str_replace('ươ ', 'uơ ', $word);
	$word = str_replace('rat ay', 'ra tay', $word);

	return $word;
}

function slug($link)
{
	$a_str = array("ă", "ắ", "ằ", "ẳ", "ẵ", "ặ", "á", "à", "ả", "ã", "ạ", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ", "Á", "À", "Ả", "Ã", "Ạ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ", "Â", "Ấ", "Ầ", "Ẩ", "Ẫ", "Ậ" );
	$e_str = array("é","è","ẻ","ẽ","ẹ","ê","ế","ề","ể","ễ","ệ","É","È","Ẻ","Ẽ","Ẹ","Ê","Ế","Ề","Ể","Ễ","Ệ");
	$d_str = array("đ","Đ");
	$o_str = array("ó","ò","ỏ","õ","ọ","ô","ố","ồ","ổ","ỗ","ộ","ơ","ớ","ờ","ở","ỡ","ợ","Ó","Ò","Ỏ","Õ","Ọ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ","Ơ","Ớ","Ờ","Ở","Ỡ","Ợ");
	$u_str = array("ú","ù","ủ","ũ","ụ","ư","ứ","ừ","ữ","ử","ự","Ú","Ù","Ủ","Ũ","Ụ","Ư","Ứ","Ừ","Ử","Ữ","Ự");
	$i_str = array("í","ì","ỉ","ị","ĩ","Í","Ì","Ỉ","Ị","Ĩ");
	$y_str = array("ý","ỳ","ỷ","ỵ","ỹ","Ý","Ỳ","Ỷ","Ỵ","Ỹ");
	$da_str = array("́","̀","̉","̃","̣");
	$link = str_replace($i_str,"i",$link);
	$link = str_replace($da_str,"",$link);
	$link = str_replace($y_str,"y",$link);
	$link = str_replace($a_str,"a",$link);
	$link = str_replace($e_str,"e",$link);
	$link = str_replace($d_str,"d",$link);
	$link = str_replace($o_str,"o",$link);
	$link = str_replace($u_str,"u",$link);

	$link=strtolower($link);
	$link=preg_replace('/[^a-z0-9]/',' ',$link);
	$link=preg_replace('/\s\s+/',' ',$link);
	$link=trim($link);
	$link=str_replace(' ','-',$link);
	return $link;
}

function deleteLineInFile($file,$string){

	$DELETE = $string; // $string can xoa

	$data = file($file); // $file txt luu tru

	$out = array();

	foreach($data as $line) {
		if(trim($line) != $DELETE) {
			$out[] = $line;
		}
	}

	$fp = fopen($file, "w+");
	flock($fp, LOCK_EX);
	foreach($out as $line) {
		fwrite($fp, $line);
	}
	flock($fp, LOCK_UN);
	fclose($fp);

}
