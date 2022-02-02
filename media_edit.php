<?php
session_start();
require 'functions.php';

if (!isset($_POST) && !isset($_SESSION['id'])) {
    redirectTo('media.php');
    exit();
}
$id = $_SESSION['id'];
$avatar = $_FILES['avatar'];

if (isset($_POST)) {
    // обработать загрузку аватара
    $destination = getAvatar();
    $avatar = $destination;
    editUserAvatar($id, $avatar);
    setFlashMassage('success', 'Данные обновлены');
    redirectTo('users.php');
}else{
    setFlashMassage('danger', 'Что-то пошло не так');
    redirectTo('media.php');
}