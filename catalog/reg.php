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
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="shortcut icon" href="https://npo-at.com/wp-content/themes/npo-at-com-2022/assets/img/favicon.svg" type="image/svg+xml">
</head>

<body style="align-items: center;">
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
            <h2>Регистрация</h2>
            <p>Уже есть аккаунт? <a href="login.php">Авторизуйтесь!</a></p>
        </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="login">Логин:</label>
                <input type="text" name="login" id="login" required>
                <label for="pas">Пароль:</label>
                <input type="password" name="pas" id="pas" required>
                <label for="pas_confirm">Подтвердите пароль:</label>
                <input type="password" name="pas_confirm" id="pas_confirm" required>
                <label for="em">Email:</label>
                <input type="email" name="em" id="em" required>
                <div>
                    <input type="submit" name="reg_user" value="Зарегистрироваться">
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

    // Обработка формы регистрации
    if (isset($_POST['reg_user'])) {
        $login = $_POST['login'];
        $password = $_POST['pas'];
        $password_confirm = $_POST['pas_confirm'];
        $email = $_POST['em'];

        // Проверка совпадения паролей
        if ($password != $password_confirm) {
            echo "Пароли не совпадают!";
        } else {
            // Проверка уникальности email
            $check_email_query = "SELECT * FROM users WHERE email = '$email'";
            $check_email_result = $conn->query($check_email_query);
        
            if ($check_email_result->num_rows > 0) {
                echo "Пользователь с таким email уже существует!";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (login, password, email)
            VALUES ('$login', '$password_hash', '$email')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Ошибка: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }

    ?>
    
</body>

</html>