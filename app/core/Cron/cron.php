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
echo "Load categories, products, prices, units done! ". date("Y_m_d H:i:s").PHP_EOL ;
exit;

// 1c выгрузка происходит каждый день с 0:30:00 по 23:00:00

// 1c загрузка происходит по крону -
// 45 00 * * * /opt/php80/bin/php /var/www/vitexopt/data/www/vitexopt.ru/app/Infrastructure/Cron/cron.php >/var/www/vitexopt/data/www/vitexopt.ru/app/Storage/import/1sCron.log
// */5 * * * * /opt/php80/bin/php /var/www/vitexopt/data/www/vitexopt.ru/app/Cron/cron.php >/usr/productTrunkate.log