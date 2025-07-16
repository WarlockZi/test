<?php
ini_set("short_open_tag", 1);
ini_set('memory_limit', '256M');

ini_set('xdebug.collect_params', '0');
ini_set('xdebug.show_local_vars', '0');
ini_set('xdebug.var_display_max_children', '-1');
ini_set('xdebug.var_display_max_data', '-1');
ini_set('xdebug.var_display_max_depth', '-1');

ini_set('log_errors_max_len', 0);
ini_set('error_prepend_string', '');
ini_set('error_append_string', '');
if (DEV) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}