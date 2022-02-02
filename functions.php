<?php

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

function addUserByAdmin($email, $password, $avatar, $status, $name, $position, $phone, $address, $vkontakte, $telegram, $instagram)
{
    $dbh = connectDb();
    // готовим запрос в БД
    $sql = 'INSERT INTO users 
        (email, password, avatar, status, name, position, phone, address, vkontakte, telegram, instagram)
        VALUES 
        (:email, :password, :avatar, :status, :name, :position, :phone, :address, :vkontakte, :telegram, :instagram)';
    $sth = $dbh->prepare($sql);
    // Выполняем запрос:
    $sth->execute([
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'avatar' => $avatar,
        'status' => $status,
        'name' => $name,
        'position' => $position,
        'phone' => $phone,
        'address' => $address,
        'vkontakte' => $vkontakte,
        'telegram' => $telegram,
        'instagram' => $instagram
    ]);
    //    $sth->bindParam(':emaile', $email);
    //    $sth->bindParam(':password', $hashedPassword);
    //    $sth->execute();
}

function editUser($id, $name, $position, $phone, $address)
{

    $dbh = new \PDO(
        'mysql:host=localhost;dbname=test',
        'root',
        ''
    );

// готовим запрос в БД
    $sql = 'UPDATE users 
            SET name = :name, position = :position, phone = :phone, address =:address
            WHERE id = :id';

//    подготавливем замену
    $sth = $dbh->prepare($sql);

    $sth->bindValue(":id", $id);
    $sth->bindValue(":name", $name);
    $sth->bindValue(":position", $position);
    $sth->bindValue(":phone", $phone);
    $sth->bindValue(":address", $address);

// Выполняем запрос:
    $sth->execute();
}

function displayFlashMassage($flashName)
{
    if(isset($_SESSION[$flashName])) {
        echo $_SESSION[$flashName];
        unset($_SESSION[$flashName]);
    }
//    <div class="alert alert-' . $flashName . ' text-dark" role="alert">
//                <strong>Уведомление! </strong>' . $_SESSION[$flashName] .
//            '</div>'
}

function getAvatar()
{
    // Check if file is selected
    if (isset($_FILES['avatar'])
        && 0 == $_FILES['avatar']['error']) {
        // Get the fileextension

        // Get the extension
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

        // check extension and upload
        if( in_array( $ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
            // Filetype if valid, process uploading

            $maxFileSize = 5 * 1024 * 1024; //5MB
            if($_FILES['avatar']['size'] > $maxFileSize){
                $error = 'File size is greater than allowed size'; // TO DO
            }

            // Get filename without extesion
            $filenameWithoutExt = basename($_FILES['avatar']['name'], '.'.$ext);
            // Generate new filename
            $newFilename = str_replace(' ', '_', $filenameWithoutExt) . '_' . time() . '.' . $ext;

            // Upload the file with new name
            move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/img/demo/avatars/' . $newFilename);
            $destination = '/img/demo/avatars/' . $newFilename;
        }
    }
    return $destination;

}

function getUserById($id)
{
    $dbh = connectDb();
    // Готовим запрос
    $sql = 'SELECT * FROM users WHERE id=:id';
    $sth = $dbh->prepare($sql);

    // Выполняем запрос:
    $sth->execute(['id' => $id]);

    // Получаем данные результата запроса:
    $user = $sth->fetch(PDO::FETCH_ASSOC);

    return $user;
}

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

function getUsersList()
{
    $dbh = connectDb();
    // Готовим запрос
    $sql = 'SELECT * FROM users';
    $sth = $dbh->prepare($sql);

    // Выполняем запрос:
    $sth->execute();

    // Получаем данные результата запроса:
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

function redirectTo($path)
{
    header('Location: ' . $path);
}

function setFlashMassage($flashName, $content)
{
    $_SESSION[$flashName] = $content;
}