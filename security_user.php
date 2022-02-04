<?php
session_start();
require 'functions.php';

// если нет авторизации или пользователь не админ, вернуться на страницу логинизации
isUserNotAdmin();

if (!isset($_POST) && !isset($_SESSION['id'])) {
    redirectTo('security.php');
    exit();
}
$id = $_SESSION['id'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['password_confirm'];

if ($passwordConfirm === $password) { // При разных паролях не срабатывает, поведение как при одинаковых
    editUserSecurity($id, $email, $password);
    setFlashMassage('success', 'Данные обновлены');
    redirectTo('users.php');
}else{
    setFlashMassage('danger', 'Пароли не совпадают');
    redirectTo('security.php');
}



