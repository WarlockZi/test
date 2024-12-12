<?php

$to   = 'vvoronik@yandex.ru';
$subj = 'test';
$body = 'test';

$to   = $argv[0];
$subj = $argv[0];
$body = $argv[0];
if (mail($to, $subj, $body)) {
    return true;
} else {
    return false;
}
//$_SERVER['argv'][0];