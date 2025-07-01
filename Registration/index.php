<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <link rel="stylesheet" href="globals.css" />
  <link rel="stylesheet" href="styleguide.css" />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
</head>

<body>
  <div class="div-wrapper" data-model-id="9:102">
    <div class="div">

      <div class="div">
        <div class="view">
          <div class="overlap-group">
            <img class="image" src="https://c.animaapp.com/pxOj12En/img/----@2x.png" />
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
                <span class="span">Контакты:<br /></span>
                <span class="text-wrapper-5">+</span>
                <span class="text-wrapper-6">79876543210</span>
              </p>
            </a>
            <a href="../account/account2.php">
              <div class="text-wrapper-7">Личный кабинет</div>
            </a>
          </div>
        </div>

        <div class="overlap">
          <div class="view-2"></div>
          <div class="view-3"></div>
          <div class="overlap-wrapper">
            <div class="overlap-2">
              <div class="text-wrapper-8">Создать аккаунт</div>

              <form method="POST" action="../api/register.php">
                <div class="overlap-group-wrapper">
                  <div class="overlap-group-2">
                    <input type="text" name="username" class="Label-4" placeholder="Логин" class="text-wrapper-9" id="Title4" required>
                  </div>
                </div>
                <div class="view-4">
                  <div class="overlap-3">
                    <input type="text" name="email" class="Label-3" placeholder="Email" id="Title3" required>
                  </div>
                </div>
                <div class="view-5">
                  <div class="overlap-4">
                   <input type="tel" name="phone" pattern="^\+\d{1,11}$" class="Label-5" placeholder="Телефон" id="Title5" required>
                  </div>
                </div>
                <div class="view-6">
                  <div class="overlap-group-2">
                    <input type="text" name="last_name" class="Label-2" placeholder="Фамилия" id="Title2" required>
                  </div>
                </div>
                <div class="view-7">
                  <div class="overlap-4">
                    <input type="text" name="first_name" class="Label-1" placeholder="Имя" id="Title1" required>
                  </div>
                </div>
                <div class="view-8">
                  <div class="overlap-3">
                    <input type="password" name="password" class="Label-6" placeholder="Пароль" id="Title6" required>
                  </div>
                </div>
                <div class="view-9">
                  <div class="overlap-3">
                    <input type="password" name="password_confirm" class="Label-7" placeholder="Подтвердите пароль" id="Title7" required>
                  </div>
                </div>
                <div class="view-10">
                  <div class="overlap-5">
                    <button type="submit" class="text-wrapper-13">Создать аккаунт</button>
                  </div>
                </div>
              </form>

              <div class="text-wrapper-14">
                <?php
                session_start();
                if (isset($_SESSION['errors'])) {
                  echo implode('<br>', $_SESSION['errors']);
                  unset($_SESSION['errors']);
                }
                ?>
              </div>
              <a href="../Authoriz/index.php">
                <div class="text-wrapper-15">У меня есть аккаунт</div>
              </a>
            </div>
          </div>
          <div class="view-11">
            <div class="overlap-6">
              <img class="img" src="https://c.animaapp.com/NJ7uSngz/img/--------------------3.png" />
              <div class="rectangle"></div>
              <div class="text-wrapper-16">Регистрация</div>
              <img class="line" src="https://c.animaapp.com/NJ7uSngz/img/line-34.svg" />
            </div>
          </div>


          <div class="view-12">
            <div class="overlap-7">
              <div class="view-13"></div>
              <div class="element-2">2025 Все права защищаены</div>
              <img class="line-2" src="https://c.animaapp.com/pxOj12En/img/line-15.svg" />
              <div class="text-wrapper-17">Пекарня, где начинается счастье!</div>
              <img class="image-2" src="https://c.animaapp.com/pxOj12En/img/-------@2x.png" />
              <div class="vector-wrapper">
                <img class="vector" src="https://c.animaapp.com/pxOj12En/img/vector-7.svg" />
              </div>
              <div class="view-14">
                <a href="../Contacts/index.php">
                  <div class="text-wrapper-18">Контакты</div>
                  <div class="overlap-8">
                    <div class="ellipse"></div>
                    <img class="img-2" src="https://c.animaapp.com/pxOj12En/img/vk@2x.png" />
                  </div>
                  <div class="overlap-group-3">
                    <div class="ellipse"></div>
                    <img class="img-2" src="https://c.animaapp.com/pxOj12En/img/whatsapp@2x.png" />
                  </div>
                  <div class="overlap-9">
                    <div class="ellipse-2"></div>
                    <img class="img-2" src="https://c.animaapp.com/pxOj12En/img/telegram@2x.png" />
                  </div>
                  <a href="mailto:info@vashapekarnya.ru" target="_blank" rel="noopener noreferrer">
                    <a href="../Contacts/index.php">
                      <div class="text-wrapper-19">info@vashapekarnya.ru</div>
                    </a>
                    <a href="../Contacts/index.php">
                      <div class="text-wrapper-20">Email</div>
                    </a>
                    <a href="../Contacts/index.php">
                      <div class="text-wrapper-21">+79876543210</div>
                    </a>
              </div>
              <div class="view-15">
                <a href="../aboutUs/index.html">
                  <div class="text-wrapper-22">О нас</div>
                </a>
                <a href="../Contacts/index.php">
                  <div class="text-wrapper-23">Оставить отзыв</div>
                </a>
                <div class="overlap-10">
                  <div class="overlap-11">
                    <a href="../account/account2.php">
                      <div class="text-wrapper-26">Личный кабинет</div>
                    </a>
                    <img class="vector-2" src="https://c.animaapp.com/pxOj12En/img/vector-9.svg" />
                  </div>
                  <a href="../Basket/basket.php">
                    <div class="text-wrapper-24">корзина</div>
                  </a>
                  <a href="../account/account2.php">
                    <div class="text-wrapper-25">заказы</div>
                  </a>
                  
                </div>
              </div>
              <div class="view-16">
                <div class="overlap-12">
                  <div class="overlap-13">
                    <a href="../menu/1Bread.html">
                      <div class="text-wrapper-27">Меню</div>
                    </a>
                    <img class="vector-3" src="https://c.animaapp.com/pxOj12En/img/vector-8.svg" />
                  </div>
                  <a href="../menu/2Buns.html">
                    <div class="text-wrapper-28">булочки</div>
                  </a>
                  <a href="../menu/6Patty.html">
                    <div class="text-wrapper-29">пирожки</div>
                  </a>
                  <a href="../menu/5Cakes.html">
                    <div class="text-wrapper-30">пирожные</div>
                  </a>
                  <a href="../menu/7Drinks.html">
                    <div class="text-wrapper-31">напитки</div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>

</html>