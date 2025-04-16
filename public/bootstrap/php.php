<?php
ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
if (DEV) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}