<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <link rel="stylesheet" href="globals.css" />
  <link rel="stylesheet" href="styleguide.css" />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <title>PieParadise</title>
</head>
  <body>
    <?php session_start();
    if (!isset($_SESSION['user'])) {
      header("Location: ../Authoriz/index.php");
      exit();
    }
    $user = $_SESSION['user'];
    $isAdmin = ($user['username'] === 'admin'); ?>
    <div class="screen" data-model-id="9:106">

      <div class="view">
        <div class="overlap-group"> <img class="image" src="../222img/лого.png" /> <a href="../index.php">
            <div class="text-wrapper">Главная</div>
          </a> <a href="../menu/1Bread.html">
            <div class="text-wrapper-2">Меню</div>
          </a> <a href="../aboutUs/index.html">
            <div class="text-wrapper-3">О нас</div>
          </a> <a href="../Contacts/index.php">
            <div class="text-wrapper-4">Контакты</div>
          </a>
          <p class="element"> <span class="span">Контакты:<br /></span> <span class="text-wrapper-5">+</span> <span
              class="text-wrapper-6">79876543210</span> </p> <a href="../account/account2.php">
            <div class="text-wrapper-7">Личный кабинет</div>
          </a> <a href="../Basket/basket.php">
            <div class="group">
              <div class="overlap-group-7">
                <div class="ellipse-14"></div> <img class="freepik-adjust" src="../222img/корзина.png" />
              </div>
          </a>
        </div>
      </div>
      <div class="overlap">
        <div class="view-2"></div> <img class="line" src="https://c.animaapp.com/DVzIvYLH/img/line-31.svg" /> <a
          href="../Basket/basket.php">
          <div class="text-wrapper-88">Корзина</div>
        </a>
        <div class="text-wrapper-8">Заказы</div>
        <form method="POST" action="../api/account.php" id="accountForm"> <a href="../Authoriz/index.php">
            <div class="text-wrapper-9">Сменить аккаунт</div>
          </a>
          <div class="overlap-wrapper">
            <div class="div-wrapper"> <button type="button" id="editBtn" onclick="toggleEditing()"
                class="text-wrapper-10">Редактировать</button> <button type="submit" name="update_account" id="saveBtn"
                class="text-wrapper-10" style="display:none;">Сохранить</button> </div>
          </div>


          <div class="view-3">
            <?php if ($isAdmin): ?>
              <div class="admin-panel-btn-container">
                <a href="../AdminPanel/index.php" class="admin-panel-btn">Панель администратора</a>
              </div>
            <?php endif; ?>
            <div class="text-wrapper-14">О вас</div>
            <div class="view-7">


              <div class="overlap-3"> <input type="text" name="first_name" class="Label-4"
                  value="<?= htmlspecialchars($user['first_name']) ?>" id="first_name" required/>
                <div class="text-wrapper-15">Имя</div> <img class="line-4"
                  src="https://c.animaapp.com/DVzIvYLH/img/line-26.svg" />
              </div>
            </div>
            <div class="view-8">
              <div class="text-wrapper-13">Фамилия</div> <input type="text" name="last_name" class="Label-5"
                value="<?= htmlspecialchars($user['last_name']) ?>" id="last_name" required/> <img class="line-5"
                src="https://c.animaapp.com/DVzIvYLH/img/line-27.svg" />
            </div>
            <div class="view-80">
              <div class="text-wrapper-13">Телефон</div> <input type="text" name="phone" class="Label-7"
                value="<?= htmlspecialchars($user['phone']) ?>" id="phone" required/> <img class="line-5"
                src="https://c.animaapp.com/DVzIvYLH/img/line-27.svg" />
            </div>
            <div class="view-4">
              <div class="text-wrapper-12">Логин</div> <input type="text" name="username" class="Label-1"
                value="<?= htmlspecialchars($user['username']) ?>" id="username" required/> <img class="line-4"
                src="https://c.animaapp.com/DVzIvYLH/img/line-26.svg" />
            </div>
            <div class="view-5">
              <div class="text-wrapper-13">Email</div> <input type="text" name="email" class="Label-2"
                value="<?= htmlspecialchars($user['email']) ?>" id="email" /> <img class="line-2"
                src="https://c.animaapp.com/DVzIvYLH/img/line-29.svg" />
            </div>
            <div class="view-6"> 
              <div class="overlap-group-2">
                <div class="text-wrapper-13">Пароль</div> <input type="password" name="password" class="Label-3"
                  value="<?= htmlspecialchars($user['password']) ?>" id="password" required/> <img class="line-3"
                  src="https://c.animaapp.com/DVzIvYLH/img/line-30.svg" />
              </div>
            </div>
            <div class="view-9" id="confirmPasswordDiv" style="display:none;">
              <div class="text-wrapper-13">Подтвердите пароль</div> <input type="password" name="confirm_password"
                class="Label-8" value="" id="confirm_password" required/> <img class="line-3"
                src="https://c.animaapp.com/DVzIvYLH/img/line-30.svg" />
            </div>
            <div id="errorMessages" class="text-wrapper-800">
              <?php if (isset($_SESSION['errors'])) {
                echo implode('<br>', $_SESSION['errors']);
                unset($_SESSION['errors']);
              } ?>
            </div>
        </form>
        <div class="overlap-group-wrapper">
          <div class="overlap-2">
            <form method="POST" action="../api/account.php" id="deleteForm"> <button type="button"
                onclick="confirmDelete()" class="text-wrapper-11">Удалить аккаунт</button> <input type="hidden"
                name="delete_account" value="1" /> </form>
          </div>
        </div>
      </div>
      <div class="orders-container" id="ordersContainer"> <!-- Сюда будут загружаться заказы через AJAX --> </div>
      <div class="view-11">
        <div class="overlap-5"> <img class="element-2" src="../222img/фон черешня.png" />
          <div class="view-12"></div>
          <div class="text-wrapper-28">Личный кабинет</div></a> <img class="line-7"
            src="https://c.animaapp.com/DVzIvYLH/img/line-35.svg" />
        </div>
      </div>
      <div class="view-13">
        <div class="overlap-6">
          <div class="view-14"></div>
          <div class="element-3">2025 Все права защищаены</div> <img class="line-8"
            src="https://c.animaapp.com/DVzIvYLH/img/line-15.svg" />
          <div class="text-wrapper-29">Пекарня, где начинается счастье!</div> <img class="image-2"
            src="../222img/лого.png" /> <button id="scrollToTop" class="scroll-to-top">
            <div class="vector-wrapper"> <img class="vector" src="https://c.animaapp.com/DVzIvYLH/img/vector-7.svg" />
            </div>
          </button> <!-- Нижний колонтитул (footer) сайта -->
          <div class="view-15"> <a href="../Contacts/index.php">
              <div class="text-wrapper-30">Контакты</div>
            </a>
            <div class="overlap-7">
              <div class="ellipse"></div> <img class="img-2" src="../222img/vk0.png" />
            </div>
            <div class="overlap-group-3">
              <div class="ellipse"></div> <img class="img-2" src="../222img/whatsapp0.png" />
            </div>
            <div class="overlap-8">
              <div class="ellipse-2"></div> <img class="img-2" src="../222img/telegram0.png" />
            </div> <a href="mailto:info@vashapekarnya.ru" target="_blank" rel="noopener noreferrer"> <a
                href="../Contacts/index.php">
                <div class="text-wrapper-31">info@vashapekarnya.ru</div>
              </a> </a> <a href="../Contacts/index.php">
              <div class="text-wrapper-32">Email</div>
            </a> <a href="../Contacts/index.php">
              <div class="text-wrapper-33">+79876543210</div>
            </a>
          </div>
          <div class="view-16"> <a href="../aboutUs/index.html">
              <div class="text-wrapper-34">О нас</div>
            </a> <a href="../Contacts/index.php">
              <div class="text-wrapper-35">Оставить отзыв</div>
            </a>
            <div class="overlap-9">
              <div class="overlap-10"> <a href="../account/account2.php">
                  <div class="text-wrapper-38">Личный кабинет</div>
                </a> <img class="vector-2" src="https://c.animaapp.com/DVzIvYLH/img/vector-9.svg" /> </div> <a
                href="../Basket/basket.php">
                <div class="text-wrapper-36">корзина</div>
              </a> <a href="../account/account2.php">
                <div class="text-wrapper-37">заказы</div>
              </a> </a>
            </div>
          </div>
          <div class="view-17">
            <div class="overlap-11">
              <div class="overlap-12"> <a href="../menu/1Bread.html">
                  <div class="text-wrapper-39">Меню</div>
                </a> <img class="vector-3" src="https://c.animaapp.com/DVzIvYLH/img/vector-8.svg" /> </div> <a
                href="../menu/2Buns.html">
                <div class="text-wrapper-40">булочки</div>
              </a> <a href="../menu/5Cakes.html">
                <div class="text-wrapper-41">пирожки</div>
              </a> <a href="../menu/6Patty.html">
                <div class="text-wrapper-42">пирожные</div>
              </a> <a href="../menu/7Drinks.html">
                <div class="text-wrapper-43">напитки</div>
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
    </div>
    <div class="modal" id="productModal">
      <div class="modal-content"> <span class="close-modal">&times;</span>
        <div id="modalContent"></div>
      </div>
    </div>
  </body>

</html>