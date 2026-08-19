<?php
$_SESSION = [];
session_start();

$s = session_id();
$_SESSION['phpSession'] = session_id();