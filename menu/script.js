
  // Кнопка "Наверх"
  const scrollToTopButton = document.getElementById('scrollToTop');
  
  if (scrollToTopButton) {
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
  


// Загрузка товаров по категории
async function loadProducts(category_slug = '') {
    currentCategory = category_slug;
    
    let url = '../api/get_products.php';
    const params = new URLSearchParams();
    if (category_slug) params.append('category', category_slug);
    
    const response = await fetch(`${url}?${params.toString()}`);
    products = await response.json();
    renderProducts(products);
}

function formatPrice(price) {
  // Убираем .00 если они есть
  return parseFloat(price).toFixed(0);
}

function renderProducts(productsToRender = products) {
    const container = document.querySelector('.product-container');
    container.innerHTML = '';
    
    // Используем productsToRender вместо products
    productsToRender.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('element-2');
        productCard.innerHTML = `
            <div class="overlap-7">
                <div class="element-wrapper">
                    <img class="element-3" src="${product.image}" alt="${product.title}">
                </div>
                <div class="text-wrapper-21">${product.title}</div>
                <div class="text-wrapper-22">руб.</div>
                <div class="view-12">
                    <div class="overlap-group-3">
                        <div class="text-wrapper-23">Заказать</div>
                    </div>
                </div>
               <div class="text-wrapper-24">${formatPrice(product.price)}</div>
                <div class="text-wrapper-25">${product.weight_grams}г</div>
            </div>
        `;
        container.appendChild(productCard);
        
        productCard.querySelector('.overlap-group-3').addEventListener('click', function(e) {
            e.preventDefault();
            addToCart(product.id);
        });
    });

    updateFoundCount(productsToRender.length);
}


async function addToCart(productId) {
    try {
        const response = await fetch('../api/add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId })
        });
        
        const result = await response.json();
        if (result.success) {
            alert('Товар добавлен в корзину!');
        } else {
            alert('Ошибка: ' + result.message);
        }
    } catch (error) {
        console.error('Ошибка:', error);
    }
}

// Функция фильтрации товаров
async function filterProducts() {
    const title = document.getElementById('Title').value.toLowerCase();
    const priceFrom = document.getElementById('PriceFrom').value;
    const priceBefore = document.getElementById('PriceBefore').value;

    let url = '../api/get_products.php';
    const params = new URLSearchParams();
    if (currentCategory) params.append('category', currentCategory);
    if (title) params.append('title', title);
    if (priceFrom) params.append('price_from', priceFrom);
    if (priceBefore) params.append('price_to', priceBefore);

    const response = await fetch(`${url}?${params.toString()}`);
    const filteredProducts = await response.json();
    
    renderProducts(filteredProducts);
}

// Функция для обновления количества найденных товаров
function updateFoundCount(count) {
    document.getElementById('foundCount').textContent = count;
}

// Функция для очистки фильтров
function clearFilters() {
    document.getElementById('Title').value = '';
    document.getElementById('PriceFrom').value = '';
    document.getElementById('PriceBefore').value = '';
    filterProducts();
}
// Инициализация страницы
window.onload = function() {
    // Определяем категорию из имени файла
    const pageMap = {
        '1Bread': 'bread',
        '2Buns': 'buns',
        '3Pies': 'pies',
        '4Cookies': 'cookies',
        '5Cakes': 'cakes',
        '6Patty': 'patty',
        '7Drinks': 'drinks'
    };
    
    const pageName = window.location.pathname.split('/').pop().split('.')[0];
    const category_slug = pageMap[pageName] || '';
    
    // Загружаем товары для выбранной категории
    loadProducts(category_slug);
    
    // Настройка обработчиков событий
    document.getElementById('Title').addEventListener('input', debounce(filterProducts, 300));
    document.getElementById('PriceFrom').addEventListener('input', debounce(filterProducts, 300));
    document.getElementById('PriceBefore').addEventListener('input', debounce(filterProducts, 300));
};

// Функция для задержки выполнения (чтобы не отправлять запрос при каждом нажатии клавиши)
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

function adjustFooterPosition() {
  const productContainer = document.querySelector('.product-container');
  const footer = document.querySelector('.overlap-13');
  const minTop = 600; // Минимальное расстояние до шапки
  const maxTop = 80; // Максимальный отступ перед подвалом
  
  if (!productContainer || !footer) return;

  // Вычисляем высоту контента
  const contentHeight = productContainer.offsetHeight + 900; // 900 - отступ сверху
  
  // Устанавливаем позицию подвала
  if (contentHeight < minTop) {
    footer.style.top = `${minTop}px`;
  } else {
    footer.style.top = `${contentHeight + maxTop}px`;
  }
  
  // Обновляем высоту основного контейнера
  document.querySelector('.overlap').style.height = 'auto';
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


async function addToCart(productId) {
    try {
        const response = await fetch('../api/add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId }) // Исправлен ключ
        });
        
        const result = await response.json();
        if (result.success) {
            alert('Товар добавлен в корзину!');
        } else {
            if (result.message.includes('зарегистрированы')) {
                if (confirm('Для добавления товара в корзину необходимо войти. Перейти на страницу входа?')) {
                    window.location.href = '../Authoriz/index.php';
                }
            } else {
                alert('Ошибка: ' + result.message);
            }
        }
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Ошибка сети. Попробуйте позже.');
    }
}

// В функции renderProducts
productCard.querySelector('.overlap-group-3').addEventListener('click', function(e) {
    e.preventDefault();
    addToCart(product.id);
});