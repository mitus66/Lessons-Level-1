<?php
session_start();
//require 'functions.php';

// take email and password
$email = $_POST['email'];
$password = $_POST['password'];

function connectDb()
{
    // Создаем объект-соединение с базой данных
    $dbh = new \PDO(
        'mysql:host=localhost;dbname=test',
        'root',
        ''
    );
    return $dbh;
}
$dbh = connectDb();

function getUserByEmail($email)
{
    $dbh = connectDb();
    // Готовим запрос
    $sql = 'SELECT * FROM users WHERE email=:email';
    $sth = $dbh->prepare($sql);

    // Выполняем запрос:
    $sth->execute(['email' => $email]);

    // Получаем данные результата запроса:
    $user = $sth->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function addUser($email, $password)
{
    $dbh = connectDb();
    // готовим запрос в БД
    $sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
    $sth = $dbh->prepare($sql);
    // Выполняем запрос:
    $sth->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
    //    $sth->bindParam(':emaile', $email);
    //    $sth->bindParam(':password', $hashedPassword);
    //    $sth->execute();
    // готовим флеш-сообщение
}

function redirectTo($path)
{
    header('Location: ' . $path);
}

function setFlashMassage($name, $content)
{
    $_SESSION[$name] = $content;
}
//setFlashMassage($name, $content);

function displayFlashMassage($name)
{
    if(isset($_SESSION[$name])) {
        echo '<div class="alert alert-' . $name . ' text-dark" role="alert">
                <strong>Уведомление!</strong>' . $_SESSION[$name] .
            '</div>';
        unset($_SESSION[$name]);
    }
}
$name = displayFlashMassage($name);


//displayFlashMassage($name);

// 1. ПРОВЕРЯЕМ, ЕСТЬ ЛИ ПОЛЬЗОВАТЕЛЬ С ТАКИМ EMAIL В БД
// 2. ЕСЛИ ПОЛЬЗОВАТЕЛЬ НАЙДЕН:
if (!empty(getUserByEmail($email))) {
    setFlashMassage('danger', 'Этот эл. адрес уже занят другим пользователем.');
    redirectTo('page_register.php');
    exit();
} else {
    // иначе,
    addUser($email, $password);
    setFlashMassage('success', 'Вы зарегистрированы');
    redirectTo('page_login.php');
}


//$login = password_verify($password, $data['password']);