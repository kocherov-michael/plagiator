# plagiator
Данный код предназначен для предания уникальности тексту при проверке ботами

1. вставляем этот код в php файл 
```
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
}?>
```

2. оборачиваем текст, который нужно закодировать
```
<?php codeString('
  текст
 ')?>
 ```
Html-теги и спецсимволы не должны попасть в текст.
Двойные кавычки допускаются.
Одинарные кавычки должны быть экранированы 
`текст перед кавычками \'текст в кавычках\' текст после кавычек`
