<?php
$paths['backup_folder'] = '/var/www/vitexopt/data/dump'; // куда будут сохранятся файлы
$paths['backup_name_www'] = 'www_dump_' . date("Y-m-d");    // имя архива
$paths['dir'] = 'www/vitexopt.ru';    // что бэкапим
$paths['delay_delete'] = 30 * 24 * 3600;    // время жизни архива (в секундах)

function backupWWW($paths)
{
    $fullFileName = $paths['backup_folder'] . '/' . $paths['backup_name_www'] . '.tar.gz';
    shell_exec("tar -czvf " . $fullFileName . " " . $paths['dir'] . "/* ");
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
$doBackupWWW = backupWWW($paths);    // делаем бэкап файлов

$time = microtime(true) - $start;     // считаем время, потраченое на выполнение скрипта

$fd = fopen("/var/www/vitexopt/data/dump/log.txt","a"); 
fwrite($fd, "www dumped wthin :  - " . $time ." date - ".date("d.m.Y H:i")."\r\n");
fwrite($fd, "www -".$doBackupWWW ."\r\n"); 

fclose($fd); 

?>