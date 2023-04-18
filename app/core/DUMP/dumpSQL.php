<?php
$paths['backup_folder'] = '/var/www/vitexopt/data/dump'; // куда будут сохранятся файлы

$paths['backup_name_sql'] = 'sql_dump_' . date("Y-m-d"). '.sql';    // имя архива

$paths['delay_delete'] = 30 * 24 * 3600;    // время жизни архива (в секундах)

$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_password'] = 'kiteLoop35';
$db['db_name'] = 'vitex_test';

function backupDB($paths,$db)
{
    $fullFileName = $paths['backup_folder'] . '/' . $paths['backup_name_sql'] ;
    $command = 'mysqldump -h' . $db['db_host'] . ' -u' . $db['db_user'] . ' -p' . $db['db_password'] . ' ' . $db['db_name'] . ' > ' . $fullFileName;
    shell_exec($command);
    return $fullFileName;
}

function deleteOldArchives($paths)
{
    $this_time = time();
    $files = glob($paths['backup_folder'] . "/*.tar.gz*");
    $deleted = array();
    foreach ($files as $file) {
        if ($this_time - filemtime($file) > $paths['delay_delete']) {
            array_push($deleted, $file);
            unlink($file);
        }
    }
    return $deleted;
}

$start = microtime(true);    // запускаем таймер

$deleteOld = deleteOldArchives($paths);    // удаляем старые архивы

$doBackupDB = backupDB($paths,$db);    // и базы данных


$time = microtime(true) - $start;     // считаем время, потраченое на выполнение скрипта

$fd = fopen("/var/www/vitexopt/data/dump/log.txt","a"); 
fwrite($fd, "sql dumped wthin :  - " . $time ." date - ".date("d.m.Y H:i")."\r\n"); 
fwrite($fd, "sql -".$doBackupDB ."\r\n"); 
fclose($fd); 

?>