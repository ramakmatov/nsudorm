<?php
// Получить значения из GET запроса
$regno = $_GET['regno'];
$status = $_GET['status'];

// Выполнить обновление статуса студента в базе данных
// Здесь вам нужно использовать ваш код для выполнения запроса к базе данных с обновлением статуса студента

// Проверить, удалось ли выполнить обновление
if ($updateSuccess) {
  echo "success";
} else {
  echo "error";
}
?>
