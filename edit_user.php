<?php
session_start();
require 'functions.php';

if (!isset($_POST) && !isset($_SESSION['id'])) {
    redirectTo('edit.php');
    exit();
}
$id = $_SESSION['id'];
$name = $_POST['name'];
$position = $_POST['position'];
$phone = $_POST['phone'];
$address = $_POST['address'];

editUser($id, $name, $position, $phone, $address);
setFlashMassage('success', 'Данные обновлены');
redirectTo('users.php');