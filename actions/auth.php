<?php
session_start();

require_once __DIR__ . '/../autoload.php';

use App\Classes\Auth;

$auth = new Auth();


if (isset($_POST['connecter'])) {
    $auth->login([
        'email'    => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? ''
    ]);
}


if (isset($_POST['inscrire'])) {
    $auth->register([
        'nom'      => $_POST['nom'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'role'     => $_POST['role'] ?? ''
    ]);
}
