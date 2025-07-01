// Полная замена содержимого файла

// Basket/script.js
const scrollToTopButton = document.getElementById('scrollToTop');

// Показываем кнопку при прокрутке вниз
window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopButton.style.display = "block";
    } else {
        scrollToTopButton.style.display = "none";
    }
};

// Прокрутка вверх при нажатии на кнопку
scrollToTopButton.onclick = function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
};

// Функция для обновления отображения корзины
async function updateCartDisplay() {
    try {
        const response = await fetch('../api/get_cart.php');
        const cartItems = await response.json();
        
        const container = document.getElementById('cartContainer');
        const grandTotalElem = document.getElementById('grand-total');
        let grandTotal = 0;
        
        // Очищаем контейнер, сохраняя только заголовки
        container.innerHTML = `
            <img class="line" src="https://c.animaapp.com/tdrWU4xI/img/line-24.svg" />
            <div class="div-2">
                <div class="text-wrapper">Название продукта</div>
                <div class="text-wrapper-2">цена</div>
                <div class="text-wrapper-3">количество</div>
                <div class="text-wrapper-4">текущее</div>
            </div>
            <div class="cart-items-container"></div>
        `;
        
        const itemsContainer = container.querySelector('.cart-items-container');
        
        if (cartItems.length === 0) {
            itemsContainer.innerHTML = `
                <div class="empty-cart">
                    <p>Товаров нет в корзине</p>
                    <a href="../menu/1Bread.html">Перейти в меню</a>
                </div>
            `;
            grandTotalElem.textContent = '0';
            return;
        }
        
        // Создаем карточки для каждого товара
        cartItems.forEach(item => {
            grandTotal += parseFloat(item.total);
            
            const itemCard = document.createElement('div');
            itemCard.className = 'cart-item';
            itemCard.dataset.cartId = item.cart_id;
            itemCard.innerHTML = `
                <div class="cart-item-image">
                    <img src="${item.image}" alt="${item.title}">
                </div>
                <div class="cart-item-title">${item.title}</div>
                <div class="cart-item-price">${item.price} руб.</div>
                <div class="cart-item-quantity">
                    <button class="quantity-btn minus" onclick="updateQuantity(${item.cart_id}, -1)">-</button>
                    <span class="quantity-value">${item.quantity}</span>
                    <button class="quantity-btn plus" onclick="updateQuantity(${item.cart_id}, 1)">+</button>
                </div>
                <div class="cart-item-total">${item.total} руб.</div>
            `;
            
            itemsContainer.appendChild(itemCard);
        });
        
        grandTotalElem.textContent = grandTotal.toFixed(0);
        adjustCartHeight();
    } catch (error) {
        console.error('Ошибка при загрузке корзины:', error);
        document.getElementById('cartContainer').innerHTML = `
            <div class="error-message">
                Ошибка загрузки корзины. Попробуйте обновить страницу.
            </div>
        `;
    }
}

// Функция обновления количества товара
async function updateQuantity(cartId, change) {
    if (change < 0) {
        const currentElement = document.querySelector(`[data-cart-id="${cartId}"]`);
        const currentQuantity = parseInt(currentElement.querySelector('.quantity-value').textContent);
        
        if (currentQuantity === 1 && !confirm('Вы действительно хотите удалить товар из корзины?')) {
            return;
        }
    }
    
    try {
        const response = await fetch('../api/update_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cart_id: cartId, change: change })
        });
        
        const result = await response.json();
        
        if (result.success) {
            if (result.deleted) {
                document.querySelector(`[data-cart-id="${cartId}"]`).remove();
                updateGrandTotal();
                
                // Если корзина пуста, обновляем отображение
                if (document.querySelectorAll('.cart-item').length === 0) {
                    updateCartDisplay();
                }
            } else {
                const itemElem = document.querySelector(`[data-cart-id="${cartId}"]`);
                itemElem.querySelector('.quantity-value').textContent = result.newQuantity;
                itemElem.querySelector('.cart-item-total').textContent = `${result.itemTotal.toFixed(0)} руб.`;
                updateGrandTotal();
            }
        } else {
            alert('Ошибка: ' + result.message);
        }
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Ошибка обновления. Попробуйте позже.');
    }
}


function formatPrice(price) {
  // Убираем .00 если они есть
  return parseFloat(price).toFixed(0);
}


// Функция пересчета итоговой суммы
function updateGrandTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const totalText = item.querySelector('.cart-item-total').textContent;
        const total = parseFloat(totalText);
        if (!isNaN(total)) grandTotal += total;
    });
    document.getElementById('grand-total').textContent = grandTotal.toFixed(0);
}

// Регулировка высоты корзины
function adjustCartHeight() {
    const cartContainer = document.getElementById('cartContainer');
    const itemsContainer = cartContainer.querySelector('.cart-items-container');
    const itemsCount = document.querySelectorAll('.cart-item').length;
    
    // Минимальная высота - 546px, увеличиваем на 180px за каждый товар
    const newHeight = 546 + (itemsCount * 180);
    cartContainer.style.height = `${newHeight}px`;
    itemsContainer.style.minHeight = `${itemsCount * 180}px`;
    
    
}

// Инициализация корзины при загрузке
document.addEventListener('DOMContentLoaded', () => {
    updateCartDisplay();
});


// Инициализация выбора способа оплаты
function initPaymentMethods() {
    const cashMethod = document.querySelector('.element-5');
    const cardMethod = document.querySelector('.vector-wrapper');
    const paymentInput = document.getElementById('paymentMethod');
    
    cashMethod.addEventListener('click', function() {
        this.classList.add('selected');
        cardMethod.classList.remove('selected');
        paymentInput.value = 'cash';
    });
    
    cardMethod.addEventListener('click', function() {
        this.classList.add('selected');
        cashMethod.classList.remove('selected');
        paymentInput.value = 'card';
    });
}




// Функция выбора способа оплаты
function selectPayment(method) {
    document.querySelectorAll('.payment-box').forEach(box => {
        box.classList.remove('selected');
    });
    
    document.getElementById(method + '-box').classList.add('selected');
    document.querySelector(`input[name="payment_method"][value="${method}"]`).checked = true;
}

// Функция проверки формы
function validateForm() {
    let isValid = true;
    const requiredFields = ['street', 'entrance', 'floor', 'apartment', 'phone'];
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        const error = document.getElementById(field + '-error');
        
        if (!input.value.trim()) {
            input.style.borderColor = '#dd1141';
            error.style.display = 'block';
            isValid = false;
        } else {
            input.style.borderColor = '#771629';
            error.style.display = 'none';
        }
    });
    
    if (!document.querySelector('input[name="payment_method"]:checked')) {
        alert('Пожалуйста, выберите способ оплаты');
        isValid = false;
    }
    
    return isValid;
}

// Функция оформления заказа
async function submitOrder() {

    // Валидация полей
    const requiredFields = ['street', 'entrance', 'floor', 'apartment', 'phone'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        const error = document.getElementById(`${field}-error`);
        
        if (!input.value.trim()) {
            input.style.borderColor = '#dd1141';
            error.style.display = 'block';
            isValid = false;
        } else {
            input.style.borderColor = '#771629';
            error.style.display = 'none';
        }
    });
    
    // Специальная проверка для телефона
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone-error');
    if (!phoneInput.value.match(/^\+7\d{10}$/)) {
        phoneInput.style.borderColor = '#dd1141';
        phoneError.textContent = 'Телефон должен быть в формате +7xxxxxxxxxx';
        phoneError.style.display = 'block';
        isValid = false;
    }
    
    if (!isValid) return;


    if (!validateForm()) return;
    
    try {
        const response = await fetch('../api/get_cart.php');
        const cartItems = await response.json();
        
        if (cartItems.length === 0) {
            alert('Ваша корзина пуста');
            return;
        }
        
        const orderData = {
            street: document.getElementById('street').value,
            entrance: document.getElementById('entrance').value,
            floor: document.getElementById('floor').value,
            apartment: document.getElementById('apartment').value,
            phone: document.getElementById('phone').value,
            payment_method: document.querySelector('input[name="payment_method"]:checked').value,
            items: cartItems
        };
        
        const orderResponse = await fetch('../api/create_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(orderData)
        });
        
        const result = await orderResponse.json();
        
        if (result.success) {
            alert('Заказ успешно оформлен!');
            window.location.href = '../account/account2.php';
        } else {
            alert('Ошибка: ' + result.message);
        }
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при оформлении заказа');
    }
}

// Инициализация при загрузке
document.addEventListener('DOMContentLoaded', () => {
    updateCartDisplay();
    
    // Добавляем обработчики для валидации
    const inputs = document.querySelectorAll('.delivery-input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#771629';
                document.getElementById(this.id + '-error').style.display = 'none';
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.delivery-input');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const errorId = this.id + '-error';
            const errorElem = document.getElementById(errorId);
            
            if (this.value.trim() !== '') {
                errorElem.style.display = 'none';
            }
        });
    });
});

  // Эффект волны для кнопок (остается без изменений)
  const buttons = document.querySelectorAll('.wave-button');
  buttons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      const wave = document.createElement('span');
      wave.className = 'wave';
      this.appendChild(wave);
      
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      
      wave.style.left = x + 'px';
      wave.style.top = y + 'px';
      
      setTimeout(() => {
        wave.remove();
        window.location.href = this.href;
      }, 500);
    });
  });

  
  