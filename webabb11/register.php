<?php
// Подключаем файл для соединения с БД
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $admin= $_POST['admin'];


    // Проверка, если логин уже существует
    $sql = "SELECT * FROM users WHERE login = '$login'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "Пользователь с таким логином уже существует!";
    } else {
        // Хешируем пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставка в базу данных
        $sql = "INSERT INTO users (login, password, admin) VALUES ('$login', '$hashed_password','$admin')";
        if ($conn->query($sql) === TRUE) {
            header("Location: http://localhost/webabb11/login.html");  // Перенаправление на страницу входа
            exit();
        } else {
            echo "Ошибка: " . $conn->error;
        }
    }
}

$conn->close();
?>
