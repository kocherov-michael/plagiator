<?php
// преобразует из строки в массив символов с учётом кириллических символов
function toArray($str) {
	$_str = $str;
	$arr = array();
	$str_len = mb_strlen($str);

	while($str_len){
		$arr[] = mb_substr($_str, 0, 1);
		$_str = mb_substr($_str, 1, $str_len);
		$str_len = mb_strlen($_str);
	}
	return $arr;
}
// получаем строку, возвращаем закодированную строку
function codeString($text) {
	// убираем пробелы в начале и конце строки
	$str = trim($text);
	// преобразовываем строку в массив
	$arr = toArray($str);
	// создаём дополнительную ссылку на массив
	$shuffleArr = $arr;
	// перемешиваем массив
	shuffle($shuffleArr);
	// к каждому символу добавляем скрытый символ
	for ($i = 0; $i < count($arr); $i++) {
		// задаём буквы, которые будут видны
		if ($arr[$i] === " ") {
			// если пробел, то обычный пробел, который переносится
			$visible = '<span style="margin-left:-0.25em;">&ensp;</span>';
		} else {
			$visible = '<span>' . $arr[$i] . '</span>';
		}
		// задаём буквы, которые не будут видны
		if ($shuffleArr[$i] === " ") {
			// если пробел, то неразрывный пробел
			$hidden = '<span style="font-size:0;">&nbsp;</span>';
		} else {
			$hidden = '<span style="font-size:0;">' . $shuffleArr[$i] . '</span>';
		}
		// добавляем по очереди в новый массив
		$newArr[] = $visible;
		$newArr[] = $hidden;
	}
	// преобразуем массив в строку и выводим в браузер
	echo implode("", $newArr);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<textarea name="textarea" id="" cols="150" rows="5" data-textarea></textarea>
	<div class="text"> 
<?php codeString('           
Нашему доброму и чудному государю предстоит величайшая роль в мире, и он так добродетелен и хорош, что Бог не оставит его, и он исполнит свое призвание задавить гидру революции, которая теперь еще ужаснее в лице этого убийцы и злодея. Мы одни должны искупить кровь праведника. На кого нам надеяться, я вас спрашиваю?.. Англия с своим коммерческим духом не поймет и не может понять всю высоту души императора Александра. Она отказалась очистить Мальту.
')?>

	</div>
</body>
</html>
