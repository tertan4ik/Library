<?php
// Подключение к базе данных
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

// Проверка роли пользователя
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] == 'да';

// Поиск книг
$search = '';
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

$sql = "SELECT * FROM books WHERE name LIKE '%$search%' OR author LIKE '%$search%' OR genre LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог книг</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <h2>Каталог книг</h2>

    <!-- Форма поиска -->
    <form method="GET" action="http://localhost/webabb11/catalog.php">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Поиск книг...">
        <button type="submit">Найти</button>
    </form>

    <div class="books-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="book">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>Автор: ' . htmlspecialchars($row['author']) . '</p>';
                echo '<p>Жанр: ' . htmlspecialchars($row['genre']) . '</p>';
                echo '<p>Год выпуска: ' . htmlspecialchars($row['publish_year']) . '</p>';
                if (!empty($row['image'])) {
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Обложка">';
                }
                echo '</div>';
            }
        } else {
            echo "Нет книг для отображения.";
        }
        ?>
    </div>

    <!-- Кнопка для добавления книги (только для администратора) -->
    <?php if ($isAdmin): ?>
        <button class="add-book-btn" onclick="window.location.href='add_book.html'">+</button>
    <?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>
