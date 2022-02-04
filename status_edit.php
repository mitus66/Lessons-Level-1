<?php
session_start();
require 'functions.php';

// если нет авторизации или пользователь не админ, вернуться на страницу логинизации
isUserNotAdmin();

$id = $_SESSION['id'];
$status = $_POST['status'];

if (isset($_POST['status'])) { // При разных паролях не срабатывает, поведение как при одинаковых
    editUserStatus($id, $status);
    setFlashMassage('success', 'Данные обновлены');
    redirectTo('users.php');
}else{
    setFlashMassage('danger', 'Пароли не совпадают');
    redirectTo('security.php');
}
