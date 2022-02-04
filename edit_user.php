<?php
session_start();
require 'functions.php';

// если нет авторизации или пользователь не админ, вернуться на страницу логинизации
isUserNotAdmin();

$id = $_SESSION['id'];
$name = $_POST['name'];
$position = $_POST['position'];
$phone = $_POST['phone'];
$address = $_POST['address'];

editUser($id, $name, $position, $phone, $address);
setFlashMassage('success', 'Данные обновлены');
redirectTo('users.php');