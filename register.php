<?php
session_start();
require 'functions.php';

// take email and password
$email = $_POST['email'];
$password = $_POST['password'];

// 1. ПРОВЕРЯЕМ, ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ С ТАКИМ EMAIL В БД
// 2. ЕСЛИ ПОЛЬЗОВАТЕЛЬ НАЙДЕН:
if (!empty(getUserByEmail($email))) {
    setFlashMassage('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirectTo('page_register.php');
    exit();
} else {
    // иначе,
    addUserSecurity($email, $password);
    setFlashMassage('success', 'Вы зарегистрированы');
    redirectTo('page_login.php');
}
