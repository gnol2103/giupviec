<?
function rewrite_detail($alias, $id)
{
	return '/' . $alias . '-p' . $id . '.html';
}

function create_slug($string)
{
	$search = array(
		'#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
		'#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
		'#(ì|í|ị|ỉ|ĩ)#',
		'#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
		'#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
		'#(ỳ|ý|ỵ|ỷ|ỹ)#',
		'#(đ)#',
		'#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
		'#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
		'#(Ì|Í|Ị|Ỉ|Ĩ)#',
		'#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
		'#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
		'#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
		'#(Đ)#',
		"/[^a-zA-Z0-9\-\_]/",
	);
	$replace = array(
		'a',
		'e',
		'i',
		'o',
		'u',
		'y',
		'd',
		'A',
		'E',
		'I',
		'O',
		'U',
		'Y',
		'D',
		'-',
	);
	$string = preg_replace($search, $replace, $string);
	$string = preg_replace('/(-)+/', '-', $string);
	$string = strtolower($string);
	return $string;
}

function remove_accent($string)
{
	$search = array(
		'#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
		'#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
		'#(ì|í|ị|ỉ|ĩ)#',
		'#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
		'#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
		'#(ỳ|ý|ỵ|ỷ|ỹ)#',
		'#(đ)#',
		'#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
		'#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
		'#(Ì|Í|Ị|Ỉ|Ĩ)#',
		'#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
		'#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
		'#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
		'#(Đ)#'
	);
	$replace = array(
		'a',
		'e',
		'i',
		'o',
		'u',
		'y',
		'd',
		'A',
		'E',
		'I',
		'O',
		'U',
		'Y',
		'D'
	);
	$string = preg_replace($search, $replace, $string);
	return $string;
}

function replaceTitle($title){
	$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
	$title  = remove_accent($title);
	$title = str_replace('/', '',$title);
	$title = preg_replace('/[^\00-\255]+/u', '', $title);

	if (preg_match("/[\p{Han}]/simu", $title)) {
		$title = str_replace(' ', '-', $title);
	}else{
		$arr_str  = array( "&lt;","&gt;","/"," / ","\\","&apos;", "&quot;","&amp;","lt;", "gt;","apos;", "quot;","amp;","&lt", "&gt","&apos", "&quot","&amp","&#34;","&#39;","&#38;","&#60;","&#62;","&nbsp;");

		$title  = str_replace($arr_str, " ", $title);
		$title  = preg_replace('/\p{P}|\p{S}/u', ' ', $title);
		$title = preg_replace('/[^0-9a-zA-Z\s]+/', ' ', $title);

		//Remove double space
		$array = array(
			'    ' => ' ',
			'   ' => ' ',
			'  ' => ' ',
		);
		$title = trim(strtr($title, $array));
		$title  = str_replace(" ", "-", $title);
		$title  = urlencode($title);
		// remove cac ky tu dac biet sau khi urlencode
		$array_apter = array("%0D%0A","%","&");
		$title  = str_replace($array_apter,"-",$title);
		$title  = strtolower($title);
	}
	return $title;
}

function makeML_content($content, $search = '', $replace = '')
{
	if ($content != '') {
		$html = str_get_html($content);
		$h2s = $html->find("h2,h3,h4,.h2-class,.h3-class");
		$patterns = array('/\d+\.\d+\.\d+\.\s/i', '/\d+\.\d+\.\s/i', '/\d+\.\s/i');
		foreach ($h2s as $h2) {
			$text = preg_replace($patterns, '', str_replace('&nbsp;', ' ', $h2->plaintext), 1);
			$id = replaceTitle($text);
			if ($id == $search && $id != '') {
				$id = $replace;
			}
			$h2->id = $id;
		}
		$html = $html->save();
		return $html;
	}
}

function makeML($content, $search = '', $replace = '')
{
	if ($content != '') {
		require_once("simple_html_dom.php");
		$html = str_get_html($content);
		$h2s = $html->find("h2,h3,h4,.h2-class,.h3-class");
		$patterns = array('/\d+\.\d+\.\d+\.\s/i', '/\d+\.\d+\.\s/i', '/\d+\.\s/i');
		$ml = "<div class='boxmucluc'><ul>";
		$i = $u = $j = 0;

		if (!empty($h2s)) {
			foreach ($h2s as $h2) {
				$text = preg_replace($patterns, '', str_replace('&nbsp;', ' ', $h2->plaintext), 1);
				$id = replaceTitle($text);
				if ($id == $search) {
					$id = $replace;
				}
				$h2->id = $id;
				if ($h2->tag == 'h2' || $h2->class == 'h2-class') {
					$i++;
					$ml .= "<li class=ml_h2><a class=ml_h2 href='#" . $id . "'>" . $i . ". " . $text . "</a></li>";
					$j = 0;
				}
				if ($h2->tag == 'h3' || $h2->class == 'h3-class') {
					$j++;
					$ml .= "<li class=ml_h3><a class=ml_h3 href='#" . $id . "'>" . $i . "." . $j . ". " . $text . "</a></li>";
					$u = 0;
				}
				if ($h2->tag == 'h4') {
					$u++;
					$ml .= "<li class=ml_h4><a class=ml_h4 href='#" . $id . "'>" . $i . "." . $j . "." . $u . ". " . $text . "</a></li>";
				}
			}
			$ml .= '</ul></div>';
			echo $ml;
		}
	}
}
