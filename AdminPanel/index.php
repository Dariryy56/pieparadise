<?php
require_once '../api/db.php';
session_start();

// Проверка авторизации администратора
if (!isset($_SESSION['user'])) {
  header("Location: ../Authoriz/index.php");
  exit();
}

// Получение списка всех таблиц в БД
$tables = [];
$stmt = $pdo->query("SHOW TABLES");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
  $tables[] = $row[0];
}

// Обработка действий с таблицами
$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $table = $_POST['table'];
    $action = $_POST['action'];
    $data = $_POST['data'] ?? [];

    switch ($action) {
      case 'add':
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $pdo->exec($sql);
        $success = "Запись успешно добавлена";
        break;

      case 'edit':
        $id = $_POST['id'];
        $updates = [];
        foreach ($data as $column => $value) {
          $updates[] = "$column = '$value'";
        }
        $set = implode(', ', $updates);
        $sql = "UPDATE $table SET $set WHERE id = $id";
        $pdo->exec($sql);
        $success = "Запись успешно обновлена";
        break;

      case 'delete':
        $id = $_POST['id'];
        $sql = "DELETE FROM $table WHERE id = $id";
        $pdo->exec($sql);
        $success = "Запись успешно удалена";
        break;
    }
  } catch (PDOException $e) {
    $error = "Ошибка: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <link rel="stylesheet" href="globals.css" />
  <link rel="stylesheet" href="styleguide.css" />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <title>Админ-панель | PieParadise</title>
</head>

<body>
  <div class="div-wrapper" data-model-id="45:2">
    <div class="div">
      <div class="view">
        <div class="overlap-group">
          <img class="image" src="../222img/лого.png" />


          <a href="../index.php">
            <div class="text-wrapper">Главная</div>
          </a>
          <a href="../menu/1Bread.html">
            <div class="text-wrapper-2">Меню</div>
          </a>
          <a href="../aboutUs/index.html">
            <div class="text-wrapper-3">О нас</div>
          </a>
          <a href="../Contacts/index.php">
            <div class="text-wrapper-4">Контакты</div>
          </a>
          <p class="element">
            <span class="span">Контакты:<br /></span>
            <span class="text-wrapper-5">+</span>
            <span class="text-wrapper-6">79876543210</span>
          </p>
          <div class="text-wrapper-7">Личный кабинет</div></a>
          <a href="../Basket/index.php">
            <div class="group">
              <div class="overlap-group-7">
                <div class="ellipse-14"></div>
                <img class="freepik-adjust" src="../222img/корзина.png" />
              </div>
          </a>
        </div>
      </div>
      <div class="view">
        <div class="overlap-group">
          <img class="image" src="../222img/лого.png" />
          <a href="../index.php">
            <div class="text-wrapper">Главная</div>
          </a>
          <a href="../menu/1Bread.html">
            <div class="text-wrapper-2">Меню</div>
          </a>
          <a href="../aboutUs/index.html">
            <div class="text-wrapper-3">О нас</div>
          </a>
          <a href="../Contacts/index.php">
            <div class="text-wrapper-4">Контакты</div>
          </a>
          <p class="element">
            <span class="span">Контакты:<br /></span>
            <span class="text-wrapper-5">+</span>
            <span class="text-wrapper-6">79876543210</span>
          </p>
          <div class="text-wrapper-7">Личный кабинет</div>
          <a href="../Basket/index.php">
            <div class="group">
              <div class="overlap-group-7">
                <div class="ellipse-14"></div>
                <img class="freepik-adjust" src="../222img/корзина.png" />
              </div>
            </div>
          </a>
        </div>
      </div>

    </div>

    <div class="tables-container">
      <?php if ($error): ?>
        <div class="global-error"><?= $error ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="global-success"><?= $success ?></div>
      <?php endif; ?>

      <?php foreach ($tables as $table): ?>
        <div class="table-card">
          <div class="table-header">
            <h3><?= ucfirst($table) ?></h3>
            <div class="table-actions">
              <button class="action-btn edit" data-table="<?= $table ?>">Изменить</button>
              <button class="action-btn delete" data-table="<?= $table ?>">Удалить</button>
              <button class="action-btn add" data-table="<?= $table ?>">Добавить</button>
            </div>
          </div>

          <div class="table-wrapper">
            <table class="admin-table">
              <thead>
                <tr>
                  <?php
                  $stmt = $pdo->query("DESCRIBE $table");
                  $columns = [];
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $columns[] = $row['Field'];
                    echo "<th>{$row['Field']}</th>";
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $data = $pdo->query("SELECT * FROM $table LIMIT 100");
                while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  foreach ($columns as $col) {
                    $value = $row[$col] ?? '';
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                  }
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

          <div class="error-container" id="error-<?= $table ?>"></div>
        </div>
      <?php endforeach; ?>
    </div>




    <div class="view-11">
      <div class="overlap-5">
        <img class="element-2" src="../222img/фон черешня.png" />
        <div class="rectangle"></div>
        <div class="text-wrapper-25">Админ. панель</div>
        <img class="line-2" src="https://c.animaapp.com/4tTGMD1p/img/line-34.svg" />
      </div>
    </div>

    <div class="view-12">
      <div class="overlap-6">
        <div class="view-13"></div>
        <div class="element-3">2025 Все права защищаены</div>
        <img class="line-3" src="https://c.animaapp.com/4tTGMD1p/img/line-15.svg" />
        <div class="text-wrapper-26">Пекарня, где начинается счастье!</div>
        <img class="image-2" src="../222img/лого.png" />


        <button id="scrollToTop" class="scroll-to-top">
          <div class="vector-wrapper">
            <img class="vector" src="https://c.animaapp.com/4tTGMD1p/img/vector-7.svg" />
          </div>
        </button>


        <div class="view-14">
          <a href="../menu/1Bread.html">
            <div class="text-wrapper-27">Контакты</div>
          </a>
          <div class="overlap-7">
            <div class="ellipse"></div>
            <img class="img-2" src="../222img/vk0.png" />
          </div>
          <div class="overlap-8">
            <div class="ellipse"></div>
            <img class="img-2" src="../222img/whatsapp0.png" />
          </div>
          <div class="overlap-group-3">
            <div class="ellipse-2"></div>
            <img class="img-2" src="../222img/telegram0.png" />
          </div>
          <a href="../Contacts/index.php">
            <div class="text-wrapper-28">info@vashapekarnya.ru</div>
            <div class="text-wrapper-29">Email</div>
            <div class="text-wrapper-30">+79876543210</div>
          </a>
        </div>
        <div class="view-15">
          <a href="../aboutUs/index.html">
            <div class="text-wrapper-31">О нас</div>
          </a>
          <a href="../Contacts/index.php">
            <div class="text-wrapper-32">Оставить отзыв</div>
          </a>
          <div class="overlap-9">
            <div class="overlap-10">
              <a href="../account/index.php">
                <div class="text-wrapper-35">Личный кабинет</div>
              </a>
              <img class="vector-2" src="https://c.animaapp.com/4tTGMD1p/img/vector-9.svg" />
            </div>
            <a href="../Basket/index.php">
              <div class="text-wrapper-33">корзина</div>
            </a>
            <a href="../account/index.php">
              <div class="text-wrapper-34">заказы</div>
            </a>

          </div>
        </div>
        <div class="view-16">
          <div class="overlap-11">
            <div class="overlap-12">
              <a href="../menu/1Bread.html">
                <div class="text-wrapper-36">Меню</div>
              </a>
              <img class="vector-3" src="https://c.animaapp.com/4tTGMD1p/img/vector-8.svg" />
            </div>
            <a href="../menu/2Buns.html">
              <div class="text-wrapper-37">булочки</div>
            </a>
            <a href="../menu/6Patty.html">
              <div class="text-wrapper-38">пирожки</div>
            </a>
            <a href="../menu/5Cakes.html">
              <div class="text-wrapper-39">пирожные</div>
            </a>
            <a href="../menu/7Drinks.html">
              <div class="text-wrapper-40">напитки</div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <!-- Модальные окна -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      <form id="editForm" method="POST">
        <input type="hidden" name="table" id="modalTable">
        <input type="hidden" name="action" id="modalAction">
        <input type="hidden" name="id" id="modalId">
        <div id="formFields"></div>
        <button type="submit" class="action-btn">Сохранить</button>
      </form>
    </div>
  </div>


  <script>
    // Полифилл для :contains()
    if (!jQuery) {
      document.querySelectorAll = document.querySelectorAll || function (selector) {
        const elements = [];
        const all = document.getElementsByTagName('*');
        for (let i = 0; i < all.length; i++) {
          if (all[i].textContent.includes(selector.replace(':contains("', '').replace('")', ''))) {
            elements.push(all[i]);
          }
        }
        return elements;
      };
    }
  </script>
</body>

</html>