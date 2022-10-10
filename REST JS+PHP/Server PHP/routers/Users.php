<?php
include "Db.php";
// Роутер
function route($method, $urlData, $formData) {

  // GET /users
  if ($method === 'GET' && count($urlData) === 0) {

  // Вытаскиваем данные всех пользователей из базы...
        $db = Db::getConnection();
        $usersList = array();
        $sql = 'SELECT * FROM users';
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
          $usersList[$i]['id'] = $row['id'];
          $usersList[$i]['name'] = $row['name'];
          $i++;
        }
        // Выводим ответ клиенту
        echo json_encode($usersList);
        return;
    }

// GET /users/{userId}
  if ($method === 'GET' && count($urlData) === 1) {
        $db = Db::getConnection();
        $appartmentsList = array();
        $userId = $urlData[0];
        $sql = 'SELECT * FROM appartments WHERE id_owner = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->execute();

        $i = 0;
        while ($row = $result->fetch()) {
          $appartmentsList[$i]['id'] = $row['id'];
          $appartmentsList[$i]['address'] = $row['address'];
          $i++;
        }
        // Выводим ответ клиенту
        echo json_encode($appartmentsList);

        return;
    }

// PUT /users/{userId}/appartment

  if ($method[2] === 'T' && count($urlData) === 2 && $urlData[1] === 'appartment')  {
        // Получаем id
        $db = Db::getConnection();
        $userId = $urlData[0];
        $sql = "INSERT INTO appartments (address, id_owner) VALUES (:address, :id)";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->bindParam(':address', $formData['address'], PDO::PARAM_STR);
        $result->execute();

        $sql = 'SELECT * FROM appartments WHERE id_owner = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->execute();

        $appartmentsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
          $appartmentsList[$i]['id'] = $row['id'];
          $appartmentsList[$i]['address'] = $row['address'];
          $i++;
        }
        // Выводим ответ клиенту
        echo json_encode($appartmentsList);

        return;
      }


              // Возвращаемошибку
          header('HTTP/1.0 400 Bad Request');
          echo json_encode(array(
                  'error' => 'Bad Request'
          ));

  }
?>
