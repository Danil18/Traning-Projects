<?php
include "Db.php";
// Роутер
function route($method, $urlData, $formData) {

// Получение информации о товаре
    // GET /goods/{goodId}
  if ($method === 'GET' && count($urlData) === 1) {
        // Получаем id товара
        $appartmentId = $urlData[0];
        // Вытаскиваем товар из базы...
        $db = Db::getConnection();
        $sql = 'SELECT counters.id, title, value FROM appartments '
        .'INNER JOIN counters INNER JOIN type_counters ON '
        .'appartments.id = counters.id_appartment AND '
        .'type_counters.id = counters.id_type  WHERE appartments.id = :id '
        .'ORDER BY counters.id ASC';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $appartmentId, PDO::PARAM_INT);
        $result->execute();

        $countersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
          $countersList[$i]['id'] = $row['id'];
          $countersList[$i]['title'] = $row['title'];
          $countersList[$i]['value'] = $row['value'];
          $i++;
        }

        // Выводим ответ клиенту
        echo json_encode($countersList);

        return;
  }


    // Добавление нового товара
    // POST /goods
    if ($method === 'POST' && count($urlData) === 1) {
          // Получаем id товара
          $appartmentId = $urlData[0];
          // Вытаскиваем товар из базы...
          $db = Db::getConnection();
          for ($i = 0; $i < count($formData); $i++){
            $sql = 'UPDATE counters SET value = :val WHERE counters.id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':val', $formData[$i]['value'], PDO::PARAM_INT);
            $result->bindParam(':id', $formData[$i]['id'], PDO::PARAM_INT);
            $result->execute();
          }

          $sql = 'SELECT counters.id, title, value FROM appartments '
          .'INNER JOIN counters INNER JOIN type_counters ON '
          .'appartments.id = counters.id_appartment AND '
          .'type_counters.id = counters.id_type  WHERE appartments.id = :id '
          .'ORDER BY counters.id ASC';

          $result = $db->prepare($sql);
          $result->bindParam(':id', $appartmentId, PDO::PARAM_INT);
          $result->execute();

          $countersList = array();
          $i = 0;
          while ($row = $result->fetch()) {
            $countersList[$i]['id'] = $row['id'];
            $countersList[$i]['title'] = $row['title'];
            $countersList[$i]['value'] = $row['value'];
            $i++;
          }
          // Выводим ответ клиенту
          echo json_encode($countersList);

          return;
    }

    // Возвращаемошибку
header('HTTP/1.0 400 Bad Request');
echo json_encode(array(
        'error' => 'Bad Request'
));

}
?>
