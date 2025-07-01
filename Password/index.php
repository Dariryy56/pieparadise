<!DOCTYPE html>
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
  <div class="div-wrapper" data-model-id="23:325">
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
 <a href="../Contacts/index.php">
          <p class="element">
            <span class="span">Контакты:</span>
            <span class="text-wrapper-6">+79876543210</span>
          </p></a>

        </div>
      </div>
      <div class="overlap">
        <div class="overlap-wrapper">
          <div class="overlap-2">
            <img class="img" src="../222img/фон черешня.png" />
            <div class="rectangle"></div>
            <div class="text-wrapper-8">Восстановление пароля</div>
            <img class="line" src="https://c.animaapp.com/JNzmvwCs/img/line-35.svg" />
          </div>
        </div>
        <div class="view-2"></div>
        <div class="view-3"></div>
        <div class="overlap-group-wrapper">
          <div class="overlap-3">
            <div class="text-wrapper-9">Придумайте новый пароль</div>

            <form method="POST" action="../api/change_password.php">
            <div class="view-4">
              <div class="overlap-group-2">
                 <input type="text" name="username" class="Label-1" placeholder="Логин" class="text-wrapper-10" id="Title" required>
              </div>
            </div>
            <div class="view-5">
              <div class="overlap-group-2">
                 <input type="password" name="new_password" class="Label-2" placeholder="Пароль" class="text-wrapper-9" id="Title" required>
              </div>
            </div>
            <div class="view-6">
              <div class="overlap-group-2">
                  <input type="password" name="new_password_confirm" class="Label-3" placeholder="Подтердите пароль" class="text-wrapper-9" id="Title" required>
              </div>
            </div>
            <div class="view-7">
              <div class="overlap-4">
                 <button type="submit" class="text-wrapper-11">Сменить пароль</button>
              </div>
            </div>
            </form>
            <div class="text-wrapper-12"> <?php
              session_start();
              if (isset($_SESSION['errors'])) {
                echo implode('<br>', $_SESSION['errors']);
                unset($_SESSION['errors']);
              }
              ?></div>
            <a href="../Authoriz/index.php">
               <button class="text-wrapper-13">Вернуться</button>
            </a>
          </div>
        </div>
        <div class="view-8">
          <div class="overlap-5">
            <div class="view-9"></div>
            <div class="element-2">2025 Все права защищаены</div>
            <img class="line-2" src="https://c.animaapp.com/JNzmvwCs/img/line-15.svg" />
            <div class="text-wrapper-14">Пекарня, где начинается счастье!</div>
            <img class="image-2" src="../222img/лого.png" />

            <div class="view-10">
              <div class="text-wrapper-15">Контакты</div>
              <div class="overlap-6">
                <div class="ellipse"></div>
                <img class="img-2" src="../222img/vk0.png" />
              </div>
              <div class="overlap-7">
                <div class="ellipse"></div>
                <img class="img-2" src="../222img/whatsapp0.png" />
              </div>
              <div class="overlap-group-3">
                <div class="ellipse-2"></div>
                <img class="img-2" src="../222img/telegram0.png" />
              </div>
              <a href="mailto:info@vashapekarnya.ru" target="_blank" rel="noopener noreferrer">
                 <a href="../Contacts/index.php"><div class="text-wrapper-16">info@vashapekarnya.ru</div></a>
              </a>
               <a href="../Contacts/index.php"><div class="text-wrapper-17">Email</div></a>
               <a href="../Contacts/index.php"><div class="text-wrapper-18">+79876543210</div></a>
            </div>
            <div class="view-11">
              <a href="../aboutUs/index.html"><div class="text-wrapper-19">О нас</div></a>
               <a href="../Contacts/index.php"><div class="text-wrapper-20">Оставить отзыв</div></a>
              <div class="overlap-8">
                 <div class="overlap-9">
               <a href="../account/account2.php"><div class="text-wrapper-23">Личный кабинет</div></a>
                  <img class="vector-2" src="https://c.animaapp.com/JNzmvwCs/img/vector-9.svg" />
                </div>
                <a href="../Contacts/index.php"> <div class="text-wrapper-21">корзина</div></a>
                 <a href="../account/account2.php"><div class="text-wrapper-22">заказы</div></a>
                
              </div>
            </div>
            <div class="view-12">
              <div class="overlap-10">
                <div class="overlap-11">
                   <a href="../menu/1Bread.html"><div class="text-wrapper-24">Меню</div></a>
                  <img class="vector-3" src="https://c.animaapp.com/JNzmvwCs/img/vector-8.svg" />
                </div>
                 <a href="../menu/2Buns.html"><div class="text-wrapper-25">булочки</div></a>
                 <a href="../menu/6Patty.html"><div class="text-wrapper-26">пирожки</div></a>
                 <a href="../menu/5Cakes.html"><div class="text-wrapper-27">пирожные</div></a>
                 <a href="../menu/7Drinks.html"><div class="text-wrapper-28">напитки</div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>