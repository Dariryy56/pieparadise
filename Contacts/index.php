<?php
session_start();

// Обработка данных после отправки формы
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? [];

// Очищаем сессию после использования
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (!empty($_SESSION['success'])): ?>
        alert("<?php echo $_SESSION['success']; ?>");
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['errors'])): ?>
        alert("<?php echo implode('\\n', $_SESSION['errors']); ?>");
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
});
</script>
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
  <div class="screen" data-model-id="9:97">
    <div class="div">
      <div class="overlap">
        <div class="view"></div>
        <div class="view-2">
          <div class="view-3">
            <img class="whatsapp" src="../222img/whatsapp0.png" />
            <img class="vk" src="../222img/vk0.png" />
            <img class="telegram" src="../222img/telegram0.png" />
          </div>
          <div class="text-wrapper">Свяжитесь с нами</div>
          <p class="element-info">
            <span class="span">
              • Телефон: +7 (987) 654 32 10 <br />
              • Электронная почта: </span>
            <a href="mailto:isip_d.yu.pilipchak@mpt.ru" target="_blank" rel="noopener noreferrer"><span
                class="text-wrapper-2">isip_d.yu.pilipchak@mpt.ru</span></a>

            <span class="span">
              График работы:<br />
              • Пн-Пт: 8:00 - 20:00 <br />
              • Сб-Bc: 9:00 - 18:00 <br /> <br />
              Мы всегда рады вашим вопросам и предложениям! <br />
              Не стесняйтесь обращаться к нам!</span>
          </p>
        </div>
        <div class="overlap-wrapper">

           <form id="feedbackForm" method="POST" action="send_email.php" class="overlap-group">
            <div class="text-wrapper-3">Оставить отзыв</div>
            <?php if (!empty($errors)): ?>
              <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                  <p class="error-message"><?= htmlspecialchars($error) ?> </p>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
              <div class="success-message"><?= htmlspecialchars($success) ?> </div>
            <?php endif; ?>

            <div class="overlap-group-wrapper">
              <div class="div-wrapper">
                <input type="text" id="name" name="name" placeholder="Имя" class="input-field" required
                  value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                <span id="name-error" class="error-message"></span>
              </div>
            </div>
            <div class="view-4">
              <div class="div-wrapper">
                <input type="email" id="email" name="email" class="input-field" placeholder="Email" required
                  value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                <span id="email-error" class="error-message"></span>
              </div>
            </div>
            <div class="view-5">
              <div class="overlap-2">
                <textarea id="message" name="message" class="textarea-field" class="text-wrapper-4"
                  placeholder="Сообщение" required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                <span id="message-error" class="error-message"> </span>
              </div>
            </div>
            <div class="view-6">
              <button type="submit" class="overlap-3">
                <div class="text-wrapper-5">Отправить</div>
              </button>
            </div>
            <p class="p"> отправляя сообщение, вы соглашаетесь с условиями предоставления услуг и политикой
              конфендациальности
            </p>
          </form>
        </div>
        <div class="view-7">
          <div class="overlap-4">
            <img class="element" src="../222img/фон черешня.png" />
            <div class="view-8"></div>
            <div class="text-wrapper-6">Контакты</div>
            <img class="line" src="https://c.animaapp.com/kVW1wYgw/img/line-34.svg" />
          </div>
        </div>
        <div class="view-9">
          <div class="overlap-5">
            <div class="view-10"></div>
            <div class="element-2">2025 Все права защищаены</div>
            <img class="img" src="https://c.animaapp.com/kVW1wYgw/img/line-15.svg" />
            <div class="text-wrapper-7">Пекарня, где начинается счастье!</div>
            <img class="image" src="../222img/лого.png" />

            <button id="scrollToTop" class="scroll-to-top">
              <div class="vector-wrapper">
                <img class="vector" src="https://c.animaapp.com/kVW1wYgw/img/vector-7.svg" />
              </div>
            </button>

            <div class="view-11">
              <a href="../Contacts/index.php">
                <div class="text-wrapper-8">Контакты</div>
              </a>
              <div class="overlap-6">
                <div class="ellipse"></div>
                <img class="img-2" src="../222img/vk0.png" />
              </div>
              <div class="overlap-group-2">
                <div class="ellipse"></div>
                <img class="img-2" src="../222img/whatsapp0.png" />
              </div>
              <div class="overlap-7">
                <div class="ellipse-2"></div>
                <img class="img-2" src="../222img/telegram0.png" />
              </div>

              <a href="../Contacts/index.php">
                <div class="text-wrapper-9">info@vashapekarnya.ru</div>
              </a>
              </a>
              <a href="../Contacts/index.php">
                <div class="text-wrapper-10">Email</div>
              </a>

              <a href="../Contacts/index.php">
                <div class="text-wrapper-11">+79876543210</div>
              </a>
              </a>
            </div>
            <div class="view-12">
              <a href="../aboutUs/index.html">
                <div class="text-wrapper-12">О нас</div>
              </a>

              <a href="../Contacts/index.php">
                <div class="text-wrapper-13">Оставить отзыв</div>
              </a>
              </a>
              <div class="overlap-8">
                <div class="overlap-9">
                  <a href="../account/account2.php">
                    <div class="text-wrapper-16">Личный кабинет</div>
                  </a>
                  <img class="vector-2" src="https://c.animaapp.com/kVW1wYgw/img/vector-9.svg" />
                </div>
                <a href="../Basket/basket.php">
                  <div class="text-wrapper-14">корзина</div>
                </a>
                <a href="../account/account2.php">
                  <div class="text-wrapper-15">заказы</div>
                </a>

              </div>
            </div>
            <div class="view-13">
              <div class="overlap-10">
                <div class="overlap-11">
                  <a href="../menu/1Bread.html">
                    <div class="text-wrapper-17">Меню</div>
                  </a>
                  <img class="vector-3" src="https://c.animaapp.com/kVW1wYgw/img/vector-8.svg" />
                </div>
                <a href="../menu/2Buns.html">
                  <div class="text-wrapper-18">булочки</div>
                </a>
                <a href="../menu/6Patty.html">
                  <div class="text-wrapper-19">пирожки</div>
                </a>
                <a href="../menu/5Cakes.html">
                  <div class="text-wrapper-20">пирожные</div>
                </a>
                <a href="../menu/7Drinks.html">
                  <div class="text-wrapper-21">напитки</div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="view-14">
        <div class="overlap-group-3">
          <img class="image-2" src="../222img/лого.png" />


          <a href="../index.php">
            <div class="text-wrapper-22">Главная</div>
          </a>
          <a href="../menu/1Bread.html">
            <div class="text-wrapper-23">Меню</div>
          </a>
          <a href="../aboutUs/index.html">
            <div class="text-wrapper-24">О нас</div>
          </a>
          <a href="../Contacts/index.php">
            <div class="text-wrapper-25">Контакты</div>
            <p class="element-3">
              <span class="text-wrapper-26">Контакты:<br /></span>
              <span class="text-wrapper-27">+</span>
              <span class="text-wrapper-28">79876543210</span>
            </p>
          </a>
          <a href="../account/account2.php">
            <div class="text-wrapper-29">Личный кабинет</div>
          </a>
          <a href="../Basket/basket.php">
            <div class="group">
              <div class="overlap-group-7">
                <div class="ellipse-14"></div>
                <img class="freepik-adjust" src="../222img/корзина.png" />
              </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>