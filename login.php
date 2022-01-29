<?php
session_start();
require 'functions.php';

// take email and password
$email = $_POST['email'];
$password = $_POST['password'];
if(isset($_POST['rememberme']))
    {$rememberme = $_POST['rememberme'];} // TO DO если есть создать куку

// 1. проверяем наличие email в БД
// 2. получаем из БД email и password
$user = getUserByEmail($email);

// 3. проверяем пароль
$login = password_verify($password, $user['password']);

// 4. если проверка прошла авторизуем и отправляем на страницу users
if($login && !empty($user)) {
    //$_SESSION['email'] = $_POST['email'];
    $_SESSION['user'] = $user;
    $_SESSION['login'] = $login;
    $_SESSION['email'] = $email;
    redirectTo('users.php');
    exit();
// 5. если нет - выводим сообщение и отправляем на повторную авторизацию
}else{
    setFlashMassage('danger', 'Логин или пароль введены неверно');
    redirectTo('page_login.php');
}
