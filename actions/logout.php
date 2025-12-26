<?php

session_start();
use App\Classes\Auth;

$auth = new Auth();
$auth->logout();