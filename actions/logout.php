<?php

session_start();
require_once __DIR__ . '/../autoload.php';

use App\Classes\Auth;

$auth = new Auth();
$auth->logout();