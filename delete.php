<?php
session_start();
require 'functions.php';

$id = $_GET['id'];

if (isset($_GET['id'])) {
    deleteUser($id);
    setFlashMassage('success', 'Данные обновлены');
    // TO DO удалить аватар с сервера
}else{
    setFlashMassage('danger', 'Что-то пошло не так');
}
redirectTo('users.php');