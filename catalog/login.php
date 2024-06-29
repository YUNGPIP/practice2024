<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="rus">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="shortcut icon" href="https://npo-at.com/wp-content/themes/npo-at-com-2022/assets/img/favicon.svg" type="image/svg+xml">
</head>

<body>
    <header>
        <div class="container header-content">
        <h1><a href="https://npo-at.com/"><img src="img/logo.svg"></a></h1>
        <nav>
            <ul class="nav-ul">
                <li><a href="https://npo-at.com/">Главная</a></li>
                <li><a href="index.php">Каталог</a></li>
            </ul>
        </nav>
        </div>
    </header>
    <div class="container">
        <div style="text-align: center">
            <h2>Авторизация</h2>
            <p>Нет аккаунта? <a href="reg.php">Зарегистрируйтесь!</a></p>
        </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="login">Логин:</label>
                <input type="text" name="login" id="login" required>
                <label for="pas">Пароль:</label>
                <input type="password" name="pas" id="pas" required>
                <div>
                    <input type="submit" name="login_user" value="Авторизоваться">
                </div>
            </form>
    </div>

<?php
    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "catalog";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Ошибка соединения: " . $conn->connect_error);
    }

    // Обработка формы авторизации
    if(isset($_POST['login_user'])) {
        $login = $_POST['login'];
        $password = $_POST['pas'];

        $sql = "SELECT * FROM users WHERE login='$login'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Авторизация успешна
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['login'];
                header("Location: index.php"); // Перенаправление на защищенную страницу
                exit();
            } else {
                echo "Неверный пароль!";
            }
        } else {
            echo "Пользователь с таким логином не найден!";
        }
    }

    $conn->close();
?>
</body>
</html>