<?php
session_start();
require 'functions.php';

// если нет авторизации или пользователь не админ, вернуться на страницу логинизации
isUserNotAdmin();

// если нет данных из формы вернуться в форму
if(empty($_POST)) {
    redirectTo('create_user.php');
    exit();
}

// проверить не занят ли емейл
$email = $_POST['email'];

if (!empty(getUserByEmail($email))) {
    setFlashMassage('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirectTo('page_register.php');
    exit();
}

// занести в базу
if(empty($_POST['email'] && $_POST['password'])) {
    setFlashMassage('danger', 'Не заполнены поля Email и/или Password');
    redirectTo('create_users.php');
} else {
    // обработать загрузку аватара
    $avatar = uploadAvatar();

    // upload user[email, password]
    $user = addUserSecurity($_POST['email'], $_POST['password']);
    // take uaser id
    $id = $user['id'];
    //edit user Info...
    editUserInfo($id, $_POST['name'], $_POST['position'], $_POST['phone'], $_POST['address']);
    editUserStatus($id, $_POST['status']);
    editUserMedia($id, $_POST['vkontakte'], $_POST['telegram'], $_POST['instagram']);
    editUserAvatar($id, $avatar);


    // подготовить сообщение
    setFlashMassage('success', 'Профиль успешно обновлен');
    // перенаправить
    redirectTo('users.php');
}

