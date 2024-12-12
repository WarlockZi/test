<?php

$to   = 'vvoronik@yandex.ru';
$subj = 'test';
$body = 'test';

//$to   = $argv[0];
//$subj = $argv[1];
//$body = $argv[2];
//$headers = $argv[3];

if (mail($to, $subj, $body)) {
    return true;
} else {
    return false;
}
//$_SERVER['argv'][0];