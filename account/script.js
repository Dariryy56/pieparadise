document.addEventListener('DOMContentLoaded', function() {
    // Инициализация - блокируем все поля при загрузке
    const inputs = document.querySelectorAll('#accountForm input');
    inputs.forEach(input => {
        input.readOnly = true;
        if (input.name === 'password') {
    input.type = 'password';
    // Не очищаем значение, если оно есть
    if (!input.value) {
        input.placeholder = '********';
    }
}
    });
    
    // Скрываем подтверждение пароля и кнопку сохранить
    document.getElementById('confirmPasswordDiv').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'none';
    
    // Прокрутка вверх
    initScrollToTop();
});

// Переключение режима редактирования
function toggleEditing() {
    const inputs = document.querySelectorAll('#accountForm input');
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const confirmDiv = document.getElementById('confirmPasswordDiv');
    
    if (editBtn.style.display !== 'none') {
        // Включаем редактирование
        inputs.forEach(input => {
            input.readOnly = false;
            if (input.name === 'password') {
                input.placeholder = 'Новый пароль';
                input.value = ''; 
            }
        });
        confirmDiv.style.display = 'block';
        editBtn.style.display = 'none';
        saveBtn.style.display = 'block';
    } else {
        // Выключаем редактирование
        inputs.forEach(input => {
            input.readOnly = true;
            if (input.name === 'password') {
                input.type = 'password';
                input.placeholder = '********';
                input.value = ''; 
            }
        });
        confirmDiv.style.display = 'none';
        editBtn.style.display = 'block';
        saveBtn.style.display = 'none';
    }
}

document.getElementById('accountForm').addEventListener('submit', function(e) {
 const email = document.getElementById('email').value;
 if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
     alert('Пожалуйста, введите корректный email');
       e.preventDefault();
      return false;
  }
   return true;
 });

// Подтверждение удаления аккаунта
function confirmDelete() {
    if (confirm("Вы действительно желаете удалить аккаунт?")) {
        document.getElementById('deleteForm').submit();
    }
}

// Прокрутка вверх
function initScrollToTop() {
    const scrollToTopButton = document.getElementById('scrollToTop');
    window.onscroll = function() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            scrollToTopButton.style.display = "block";
        } else {
            scrollToTopButton.style.display = "none";
        }
    };
    scrollToTopButton.onclick = function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };
}

document.querySelector('.text-wrapper-36').addEventListener('click', function(e) {
    e.preventDefault();
    window.location.href = '../Basket/basket.php';
});

// Функция загрузки заказов
async function loadOrders() {
    try {
        const response = await fetch('../api/get_orders.php');
        if (!response.ok) throw new Error('Network response was not ok');
        
        const orders = await response.json();
        const container = document.getElementById('ordersContainer');
        container.innerHTML = '';
        
        if (!orders || orders.length === 0) {
            container.innerHTML = '<p>У вас пока нет заказов</p>';
            return;
        }
        
        orders.forEach(order => {
            const orderCard = document.createElement('div');
            orderCard.className = 'order-card';
            
            // Форматируем дату доставки
            const deliveryDate = new Date(order.delivery_date);
            const formattedDate = deliveryDate.toLocaleDateString('ru-RU', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            
            orderCard.innerHTML = `
                <div class="order-header">
                    <span>Заказ #${order.id}</span>
                    <span>${order.status}</span>
                </div>
                <div class="order-info">
                    <div><strong>Дата доставки:</strong> ${formattedDate}</div>
                    <div><strong>Адрес:</strong> ул. ${order.street}, подъезд ${order.entrance}, этаж ${order.floor}, кв. ${order.apartment}</div>
                    <div><strong>Телефон:</strong> ${order.phone}</div>
                    <div><strong>Способ оплаты:</strong> ${order.payment_method === 'cash' ? 'Наличные' : 'Карта'}</div>
                    <div><strong>Сумма:</strong> ${order.total} руб.</div>
                </div>
                <div class="order-items">
                    <h4>Товары:</h4>
                    ${order.items.map(item => `
                        <div class="order-item" data-product-id="${item.product_id}">
                            <img src="${item.image}" alt="${item.title}">
                            <span>${item.title} (${item.quantity} × ${item.price} руб.)</span>
                        </div>
                    `).join('')}
                </div>
                <button class="delete-order" data-order-id="${order.id}">Удалить заказ</button>
            `;
            container.appendChild(orderCard);
        });
        
        // Добавляем обработчики событий для товаров
        document.querySelectorAll('.order-item').forEach(item => {
            item.addEventListener('click', function() {
                const productId = this.dataset.productId;
                showProductDetails(productId);
            });
        });
        
    } catch (error) {
        console.error('Ошибка загрузки заказов:', error);
        document.getElementById('ordersContainer').innerHTML = `
            <div class="error">Ошибка загрузки заказов. Пожалуйста, попробуйте позже.</div>
        `;
    }
}

// Вызываем загрузку заказов при загрузке страницы
document.addEventListener('DOMContentLoaded', loadOrders);




// Обработка клика по товару в заказе
document.addEventListener('click', function(e) {
    if (e.target.closest('.order-item')) {
        const productId = e.target.closest('.order-item').dataset.productId;
        showProductDetails(productId);
    }
    
    if (e.target.closest('.close-modal')) {
        document.getElementById('productModal').style.display = 'none';
    }
});


// Обновленный показ деталей товара
async function showProductDetails(productId) {
    try {
        const response = await fetch(`../api/get_product.php?id=${productId}`);
        const product = await response.json();
        
        const modal = document.getElementById('productModal');
        const modalContent = document.getElementById('modalContent');
        
        modalContent.innerHTML = `
            <h3>${product.title}</h3>
            <img src="${product.image}" alt="${product.title}">
            <p><strong>Цена:</strong> ${product.price} руб.</p>
            <p><strong>Вес:</strong> ${product.weight_grams} г</p>
            <p><strong>Описание:</strong> ${product.description || 'Нет описания'}</p>
            <p><strong>Состав:</strong> ${product.composition || 'Информация отсутствует'}</p>
        `;
        
        modal.style.display = 'flex';
    } catch (error) {
        console.error('Ошибка загрузки товара:', error);
        modalContent.innerHTML = '<p>Произошла ошибка при загрузке информации о товаре</p>';
    }
}

// Закрытие модального окна при клике вне его
window.addEventListener('click', function(e) {
    const modal = document.getElementById('productModal');
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

// Обработка удаления заказа
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-order')) {
        const orderId = e.target.dataset.orderId;
        if (confirm('Вы уверены, что хотите удалить этот заказ?')) {
            deleteOrder(orderId);
        }
    }
});

async function deleteOrder(orderId) {
    try {
        const response = await fetch('../api/delete_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ order_id: orderId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Заказ успешно удален');
            loadOrders(); // Обновляем список заказов
        } else {
            alert('Ошибка: ' + result.message);
        }
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при удалении заказа');
    }
}




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
  