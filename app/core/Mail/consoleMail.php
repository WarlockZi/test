<?php

//$to   = 'vvoronik@yandex.ru';
//$subj = 'test';
$body = 'test';

//$to   = $argv[1];
//$subj = $argv[2];
//$body = $argv[3];

$to   = $argv[1];
$subj = $argv[2];
//$body = $argv[2];
////$headers = $argv[3];
//
//$to   = $_SERVER['argv'][0];
//$subj = $_SERVER['argv'][1];
//$body = $_SERVER['argv'][2];

if (mail($to, $subj, $body)) {
    return true;
} else {
    return false;
}
//$_SERVER['argv'][0];