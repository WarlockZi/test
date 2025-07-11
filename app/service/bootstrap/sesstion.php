<?php
session_unset();
session_start();
$_SESSION['phpSession'] = session_id();