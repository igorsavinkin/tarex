<?php
//error_reporting(E_ALL);

//require_once('dbconnection.php');

function transliterate($st) {
 $translit = array(
 
            'а' => 'a',   'б' => 'b',   'в' => 'v',
 
            'г' => 'g',   'д' => 'd',   'е' => 'e',
 
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
 
            'и' => 'i',   'й' => 'j',   'к' => 'k',
 
            'л' => 'l',   'м' => 'm',   'н' => 'n',
 
            'о' => 'o',   'п' => 'p',   'р' => 'r',
 
            'с' => 's',   'т' => 't',   'у' => 'u',
 
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
 
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
 
            'ь' => '',  'ы' => 'y',   'ъ' => '',
 
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya', 
			
					 
			'№' => 'N',  ' ' => '',
         
 
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
 
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
 
            'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
 
            'И' => 'I',   'Й' => 'J',   'К' => 'K',
 
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
 
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
 
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
 
            'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
 
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
 
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
 
            'Э' => 'E\'',   'Ю' => 'YU',  'Я' => 'YA',
 
        );
	
		$word = strtr($st, $translit); 
		return $word;
		// транслитерация. Переменная $word получит значение 'prochee'
  
}
$max_image_size		= 10*1024*1024;
$valid_types 		=  array("gif","jpg", "png", "jpeg","JPG");

$uploaddir = 'files/';

if (isset($_FILES['ufile']['name'])){
	$uploadfile = $uploaddir . $_FILES['ufile']['name'];
	
	$filename = $_FILES['ufile']['tmp_name'];
	$ext = substr($_FILES['ufile']['name'], 1 + strrpos($_FILES['ufile']['name'], "."));

	$str = transliterate($uploadfile);
	$str = strtolower($str);	
	
	if (filesize($filename) > $max_image_size) {
			echo 'Error: File size > 10M.';
			return;
	} elseif (!in_array($ext, $valid_types)) {
			echo 'Error: Invalid file type.';
			return;
	}		
}	
//echo  $str; 
//echo '{"success":true}';

if (move_uploaded_file($_FILES['ufile']['tmp_name'],$str)){
	echo '{"success":true}';
}else{
	echo '{"success":false}';
}
?>