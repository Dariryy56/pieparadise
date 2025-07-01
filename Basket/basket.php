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
  <div class="div-wrapper" data-model-id="9:104">
   
      <div class="overlap">
        <div class="view"></div>
        <div class="view-2" id="cartContainer">
          <img class="line" src="https://c.animaapp.com/tdrWU4xI/img/line-24.svg" />
          <div class="div-2">
            <div class="text-wrapper">Название продукта</div>
            <div class="text-wrapper-2">цена</div>
            <div class="text-wrapper-3">количество</div>
            <div class="text-wrapper-4">текущее</div>
          </div>

        </div>
        <div class="view-3">
          <div class="overlap-2">
            <div class="text-wrapper-19">Купить</div>
          </div>
        </div>
        <div class="view-4">
          <div class="text-wrapper-20">Итоговая цена:</div>
          <div class="text-wrapper-21">руб.</div>
          <div class="overlap-3">
            <div class="text-wrapper-22" id="grand-total">0</div>
            <img class="line-2" src="https://c.animaapp.com/tdrWU4xI/img/line-25.svg" />
          </div>
        </div>


        <div class="view-5">
    <div class="overlap-4">
        <div class="text-wrapper-27">Доставка</div>
        </div>
        <div class="view-11">
            <div class="text-wrapper-24">Улица</div>
            <input type="text" id="street" name="street" class="delivery-input1" required>
            <div class="error-message" id="street-error">Пожалуйста, введите улицу</div>
            <img class="line-7" src="https://c.animaapp.com/tdrWU4xI/img/line-40.svg" />
        </div>
        
        <div class="view-8">
            <div class="text-wrapper-24">Подъезд</div>
            <input type="text" id="entrance" name="entrance" class="delivery-input2" required>
            <div class="error-message" id="entrance-error">Пожалуйста, введите подъезд</div>
            <img class="line-4" src="https://c.animaapp.com/tdrWU4xI/img/line-42.svg" />
        </div>
        
        <div class="view-9">
            <div class="text-wrapper-24">Этаж</div>
            <input type="text" id="floor" name="floor" class="delivery-input3" required>
            <div class="error-message" id="floor-error">Пожалуйста, введите этаж</div>
            <img class="line-5" src="https://c.animaapp.com/tdrWU4xI/img/line-42.svg" />
        </div>
        
        <div class="view-10">
            <div class="text-wrapper-24">Квартира</div>
            <input type="text" id="apartment" name="apartment" class="delivery-input4" required>
            <div class="error-message" id="apartment-error">Пожалуйста, введите квартиру</div>
            <img class="line-6" src="https://c.animaapp.com/tdrWU4xI/img/line-43.svg" />
        </div>
        
        <div class="view-6">
            <div class="text-wrapper-24">Телефон</div>
            <input type="tel" id="phone" name="phone" class="delivery-input5" required>
            <div class="error-message" id="phone-error">Пожалуйста, введите телефон</div>
            <img class="line-7" src="https://c.animaapp.com/tdrWU4xI/img/line-40.svg" />
        </div>
        

        <div class="view-7">
        <div class="text-wrapper-23">Оплата</div>
        <div class="payment-methods">
            <div class="payment-option" onclick="selectPayment('cash')">
                <div class="payment-box" id="cash-box"></div>
                <div class="text-wrapper-25">наличные при получении</div>
                <input type="radio" name="payment_method" value="cash" style="display: none;">
            </div>
            <div class="payment-option" onclick="selectPayment('card')">
                <div class="payment-box" id="card-box"></div>
                <div class="text-wrapper-26">картой</div>
                <input type="radio" name="payment_method" value="card" style="display: none;">
            </div>
        </div>
        </div>
    </div>

<!-- Кнопка заказать -->
<div class="view-3">
    <div class="overlap-2" onclick="submitOrder()">
        <div class="text-wrapper-19">Заказать</div>
    </div>
</div>

        <div class="view-12">
          <div class="overlap-5">
            <img class="element-7" src="../222img/фон черешня.png" />
            <div class="rectangle-3"></div>
            <div class="text-wrapper-28">Корзина</div>
            <img class="line-8" src="https://c.animaapp.com/tdrWU4xI/img/line-34.svg" />
          </div>
        </div>
        <div class="view-13">
          <div class="overlap-6">
            <div class="view-14"></div>
            <div class="element-8">2025 Все права защищаены</div>
            <img class="line-9" src="https://c.animaapp.com/tdrWU4xI/img/line-15.svg" />
            <div class="text-wrapper-29">Пекарня, где начинается счастье!</div>
            <img class="image" src="../222img/лого.png" />

            <button id="scrollToTop" class="scroll-to-top">
              <div class="img-wrapper">
                <img class="vector-2" src="https://c.animaapp.com/tdrWU4xI/img/vector-7.svg" />
              </div>
            </button>


            
            <div class="view-15">

              <a href="../Contacts/index.php">
                <div class="text-wrapper-30">Контакты</div>
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
                <div class="text-wrapper-31">info@vashapekarnya.ru</div>
              </a>
              <a href="../Contacts/index.php">
                <div class="text-wrapper-32">Email</div>
              </a>
              <a href="../Contacts/index.php">
                <div class="text-wrapper-33">+79876543210</div>
              </a>
            </div>
            <div class="view-16">
              <a href="../aboutUs/index.html">
                <div class="text-wrapper-34">О нас</div>
              </a>
              <a href="../Contacts/index.php">
                <div class="text-wrapper-35">Оставить отзыв</div>
              </a>
              <div class="overlap-9">
                <div class="overlap-10">
                  <a href="../account/account2.php">
                    <div class="text-wrapper-38">Личный кабинет</div>
                  </a>
                  <img class="vector-3" src="https://c.animaapp.com/tdrWU4xI/img/vector-9.svg" />
                </div>
                <a href="../Basket/basket.php">
                  <div class="text-wrapper-36"> корзина</div>
                </a>
                <a href="../account/account2.php">
                  <div class="text-wrapper-37">заказы</div>
                </a>

              </div>
            </div>
            <div class="view-17">
              <div class="overlap-11">
                <div class="overlap-12">
                  <a href="../menu/1Bread.html">
                    <div class="text-wrapper-39">Меню</div>
                  </a>
                  <img class="vector-4" src="https://c.animaapp.com/tdrWU4xI/img/vector-8.svg" />
                </div>
                <a href="../menu/2Buns.html">
                  <div class="text-wrapper-40">булочки</div>
                </a>
                <a href="../menu/6Patty.html">
                  <div class="text-wrapper-41">пирожки</div>
                </a>
                <a href="../menu/5Cakes.html">
                  <div class="text-wrapper-42">пирожные</div>
                </a>
                <a href="../menu/7Drinks.html">
                  <div class="text-wrapper-43">напитки</div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="view-18">
        <div class="overlap-group-4">
          <img class="image-2" src="../222img/лого.png" />
          <a href="../index.php">
            <div class="text-wrapper-44">Главная</div>
          </a>
          <a href="../menu/1Bread.html">
            <div class="text-wrapper-45">Меню</div>
          </a>
          <a href="../aboutUs/index.html">
            <div class="text-wrapper-46">О нас</div>
          </a>
          </a>
          <a href="../Contacts/index.php">
            <div class="text-wrapper-47">Контакты</div>
          </a>
          </a>
          <a href="../Contacts/index.php">
            <p class="p">
              <span class="span">Контакты:<br /></span>
              <span class="text-wrapper-48">+</span>
              <span class="text-wrapper-49">79876543210</span>
            </p>
          </a>
          <a href="../account/account2.php">
            <div class="text-wrapper-50">Личный кабинет</div>
          </a>
          </a>

        </div>
      </div>
    
  </div>
</body>

</html>