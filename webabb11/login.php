<?php
// Подключаем файл для соединения с БД
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Получаем пользователя из базы
    $sql = "SELECT * FROM users WHERE login = '$login'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Проверка пароля
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = $user['login'];
            $_SESSION['admin'] = $user['admin'];
            // Перенаправление в каталог
            header("Location: http://localhost/webabb11/catalog.php");
            exit();
        } else {
            echo "$password";
        }
    } else {
        echo "Пользователь не найден!";
    }
}

$conn->close();
?>
