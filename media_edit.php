<?php
session_start();
require 'functions.php';

// если нет авторизации или пользователь не админ, вернуться на страницу логинизации
isUserNotAdmin();

$id = $_SESSION['id'];
//$user = getUserById($id);
$avatar = $_FILES['avatar'];

if (isset($_POST)) {
    // обработать загрузку аватара
//    $destination = getAvatar();
//    $avatar = $destination;
    $avatar = getUserAvatar();

    editUserAvatar($id, $avatar);
    setFlashMassage('success', 'Данные обновлены');
    redirectTo('users.php');
}else{
    setFlashMassage('danger', 'Что-то пошло не так');
    redirectTo('media.php');
}