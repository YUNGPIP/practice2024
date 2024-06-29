<?php
session_start();
include_once('functions/functions.php');
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Каталог IT-сервисов НПО АТ</title>
  <link href="css/styles.css" rel="stylesheet">
  <link rel="shortcut icon" href="https://npo-at.com/wp-content/themes/npo-at-com-2022/assets/img/favicon.svg" type="image/svg+xml">
</head>

<body>
  <header>
    <div class="container header-content">
      <h1><a href="https://npo-at.com/"><img src="img/logo.svg"></a></h1>
      <nav>
        <ul class="nav-ul">
          <li><a href="https://npo-at.com/">Главная</a></li>
          <li><a href="<?php if (isset($_SESSION['user_id'])) {echo 'cab.php';}else{echo 'login.php';} ?>">Личный кабинет</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class="container">
      <h1>Каталог сервисов</h1>
      <?php
      $categories = getCategoriesFromDatabase();

      foreach (array_slice($categories, 0, 3) as $category) {
        echo "<h2>" . $category['name'] . "</h2>";
        echo "<div class='service-list'>";

        $services = getServicesForCategory($category['id']);

        foreach ($services as $service) {
          echo "<div class='service-card'>";
          echo "<span style='width: 50px;'><div class='services__item-icon' decoding='async' loading='lazy' style='object-fit: contain; background-image:url(" . $service['logo'] . ");' alt='" . $service['title'] . "'></div></span>";
          echo "<div decoding='async' loading='lazy' style='margin-left: 15px; display: grid;'>";
          echo "<h3>" . $service['title'] . "</h3>";
          echo "<p>" . $service['description'] . "</p>";
          echo "</div>";
          echo "</div>";
        }

        echo "</div>";
      }
      ?>
      <h2>Все сервисы</h2>
      <div class="service-list">
      <?php
        $servicesData = getServicesFromDatabase();

        foreach ($servicesData as $service) {
          echo "<div class='service-card'>";
          echo "<span style='width: 50px;'><div class='services__item-icon' decoding='async' loading='lazy' style='object-fit: contain; background-image:url(" . $service['logo'] . ");' alt='" . $service['title'] . "'></div></span>";
          echo "<div decoding='async' loading='lazy' style='margin-left: 15px; display: grid;'>";
          echo "<h3>" . $service['title'] . "</h3>";
          echo "<p>" . $service['description'] . "</p>";
          echo "</div>";
          echo "</div>";
        }
        ?>
      </div>
    </div>
    
  </main>
</body>

</html>