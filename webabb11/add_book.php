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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $genre = $_POST['genre'];
    $publish_year = $_POST['publish_year'];

    // Загружаем изображение (если есть)
    // Добавляем книгу в базу данных
    $sql = "INSERT INTO books (name, author, publisher, genre, publish_year) VALUES ('$name', '$author', '$publisher', '$genre', '$publish_year')";
    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/webabb11/catalog.php");
        exit();
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

$conn->close();
?>
