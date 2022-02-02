<?php
session_start();
require 'functions.php';


if (!isset($_POST) && !isset($_SESSION['id'])) {
    redirectTo('users.php');
    exit();
}
$id = $_GET['id'];

if (isset($_POST['id'])) {
    deleteUser($id);
    setFlashMassage('success', 'Данные обновлены');
    // TO DO удалить аватар с сервера
    redirectTo('users.php');
}else{
    setFlashMassage('danger', 'Что-то пошло не так');
    redirectTo('media.php');
}