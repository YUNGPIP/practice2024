<?php

function getServicesForCategory($categoryId) {
    include('connect.php');
    // Подготовка SQL-запроса
    $stmt = $conn->prepare("SELECT * FROM services WHERE category_id = ?");
    $stmt->bind_param("i", $categoryId);
  
    // Выполнение запроса
    $stmt->execute();
    $result = $stmt->get_result();
  
    // Проверка и получение данных
    if ($result->num_rows > 0) {
        $services = array();
        while ($row = $result->fetch_assoc()) {
            $services[] = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'logo' => $row['logo'],
                'category_id' => $row['category_id']
            );
        }
        return $services;
    } else {
        return array();
    }
  
    // Закрытие соединения
    $stmt->close();
    $conn->close();
  }
  
  function getCategoriesFromDatabase() {
    include('connect.php');

    // Выполнение запроса для получения данных о категориях
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);
  
    // Проверка и получение данных
    if ($result->num_rows > 0) {
        $categories = array();
        while ($row = $result->fetch_assoc()) {
            $categories[] = array(
                'id' => $row['id'],
                'name' => $row['name']
            );
        }
        return $categories;
    } else {
        return array();
    }
  
    // Закрытие соединения
    $conn->close();
  }
  function getServicesFromDatabase() {
    include('connect.php');

    // Выполнение запроса для получения данных о сервисах
    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);

    // Проверка и получение данных
    if ($result->num_rows > 0) {
        $services = array();
        while ($row = $result->fetch_assoc()) {
            $services[] = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'logo' => $row['logo'],
                'description' => $row['description'],
                'category_id' => $row['category_id']
            );
        }
        return $services;
    } else {
        return array();
    }

    // Закрытие соединения
    $conn->close();
}
?>