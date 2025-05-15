<?php
ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');
ini_set('xdebug.collect_params', '0');
ini_set('xdebug.show_local_vars  ', '0');

if (DEV) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}