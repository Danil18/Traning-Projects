<?php
include "Db.php";
// Роутер
function route($method, $urlData, $formData) {
      // GET /counters/type
      if($method === 'GET' && count($urlData) === 1 && $urlData[0] === 'type'){
            // Вытаскиваем товар из базы...
            $db = Db::getConnection();
            $sql = 'SELECT * FROM type_counters';

            $result = $db->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $typeList = array();
            $i = 0;
            while ($row = $result->fetch()) {
              $typeList[$i]['id'] = $row['id'];
              $typeList[$i]['title'] = $row['title'];
              $i++;
            }
            // Выводим ответ клиенту
            echo json_encode($typeList);

            return;
      }

      if($method === 'GET' && count($urlData) === 1){
            // Вытаскиваем товар из базы...
            $db = Db::getConnection();
            $idCounter = $urlData[0];

            $sql = 'SELECT counters.id, title, value FROM counters INNER JOIN '
            .'type_counters ON counters.id_type = type_counters.id WHERE '
            .'counters.id = :id ORDER BY counters.id ASC';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $idCounter, PDO::PARAM_INT);
            $result->execute();

            $counter = array();
            $i = 0;
            while ($row = $result->fetch()) {
              $counter[$i]['id'] = $row['id'];
              $counter[$i]['title'] = $row['title'];
              $counter[$i]['value'] = $row['value'];
              $i++;
            }

            // Выводим ответ клиенту
            echo json_encode($counter);

            return;
      }

      if ($method === 'POST' && count($urlData) === 1) {
            // Получаем id товара
            $counterId = $urlData[0];
            // Вытаскиваем товар из базы...
            $db = Db::getConnection();
            $sql = 'UPDATE counters SET value = :val WHERE counters.id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':val', $formData['value'], PDO::PARAM_INT);
            $result->bindParam(':id', $formData['id'], PDO::PARAM_INT);
            $result->execute();

            $sql = 'SELECT counters.id, title, value FROM counters INNER JOIN '
            .'type_counters ON counters.id_type = type_counters.id WHERE '
            .'counters.id = :id ORDER BY counters.id ASC';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $counterId, PDO::PARAM_INT);
            $result->execute();

            $counter = array();
            $i = 0;
            while ($row = $result->fetch()) {
              $counter[$i]['id'] = $row['id'];
              $counter[$i]['title'] = $row['title'];
              $counter[$i]['value'] = $row['value'];
              $i++;
            }
            // Выводим ответ клиенту
            echo json_encode($counter);

            return;
      }


      if($method[2] === 'T' && count($urlData) === 0){
            // Вытаскиваем товар из базы...
            $db = Db::getConnection();
            $sql = 'INSERT INTO counters (id_type, id_appartment) VALUES (:id_type, :id_appartment)';

            $result = $db->prepare($sql);
            $result->bindParam(':id_type', $formData['typeId'], PDO::PARAM_INT);
            $result->bindParam(':id_appartment', $formData['appartmentId'], PDO::PARAM_INT);
            $result->execute();

            $sql = 'SELECT counters.id, title, value FROM appartments '
            .'INNER JOIN counters INNER JOIN type_counters ON '
            .'appartments.id = counters.id_appartment AND '
            .'type_counters.id = counters.id_type  WHERE appartments.id = :id '
            .'ORDER BY counters.id ASC';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $formData['appartmentId'], PDO::PARAM_INT);
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

    // Возвращае мошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
          'error' => 'Bad Request'
    ));

  }
?>
