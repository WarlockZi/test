<?php
// Создаем поток
$opts = array(
	'http' => array(
		'method' => "GET",
		'header' => "Accept-language: en\r\n" .
			"Cookie: foo=bar\r\n"
	)
);

$context = stream_context_create($opts);

//for php4 use fopen
$html_data = file_get_contents('https://vitexopt.ru/adminsc/sync/load', false, $context);
echo "DONE!";
exit;

?>
