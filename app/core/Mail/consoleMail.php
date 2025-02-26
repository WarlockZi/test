<?php
$to   = $argv[1];
$subj = $argv[2];
$body = $argv[3];
////$headers = $argv[3];


if (mail($to, $subj, $body)) {
    return true;
} else {
    return false;
}
