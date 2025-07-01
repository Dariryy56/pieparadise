 // script.js
 let products = []; // Массив для хранения данных о товарах из БД

 // Функция для загрузки данных о товарах из БД (нужно реализовать на PHP)
 async function loadProducts() {
  const response = await fetch('get_products.php');
  products = await response.json();
  renderProducts();
 }

 // Функция для отображения товаров на странице
 function renderProducts() {
  const container = document.querySelector('.product-container');
  container.innerHTML = ''; // Очищаем контейнер перед отображением

  products.forEach(product => {
  const productCard = document.createElement('div');
  productCard.classList.add('element-2');
  productCard.innerHTML = `
  <div class="overlap-7">
  <div class="element-wrapper">
  <img class="element-3" src="${product.image}" alt="${product.name}">
  </div>
  <div class="text-wrapper-21">${product.name}</div>
  <div class="text-wrapper-22">руб.</div>
  <div class="view-12">
  <div class="overlap-group-3">
  <div class="text-wrapper-23">Заказать</div>
  </div>
  </div>
  <div class="text-wrapper-24">${product.price}</div>
  <div class="text-wrapper-25">${product.weight}г</div>
  </div>
  `;
  container.appendChild(productCard);
  });
 }

 // Функция фильтрации товаров
 function filterProducts() {
  const title = document.getElementById('Title').value.toLowerCase();
  const priceFrom = document.getElementById('PriceFrom').value;
  const priceBefore = document.getElementById('PriceBefore').value;

  const filteredProducts = products.filter(product => {
  const productName = product.name.toLowerCase();
  const productPrice = product.price;

  const titleMatch = productName.includes(title);
  const priceFromMatch = priceFrom ? productPrice >= priceFrom : true;
  const priceBeforeMatch = priceBefore ? productPrice <= priceBefore : true;

  return titleMatch && priceFromMatch && priceBeforeMatch;
  });

  renderFilteredProducts(filteredProducts);
 }

 // Функция для отображения отфильтрованных товаров
 function renderFilteredProducts(filteredProducts) {
  const container = document.querySelector('.product-container');
  container.innerHTML = '';

  filteredProducts.forEach(product => {
  const productCard = document.createElement('div');
  productCard.classList.add('element-2');
  productCard.innerHTML = `
  <div class="overlap-7">
  <div class="element-wrapper">
  <img class="element-3" src="../uploads/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title']) ?>">
  </div>
  <div class="text-wrapper-21">${product.name}</div>
  <div class="text-wrapper-22">руб.</div>
  <div class="view-12">
  <div class="overlap-group-3">
  <div class="text-wrapper-23">Заказать</div>
  </div>
  </div>
  <div class="text-wrapper-24">${product.price}</div>
  <div class="text-wrapper-25">${product.weight}г</div>
  </div>
  `;
  container.appendChild(productCard);
  });

  updateFoundCount(filteredProducts.length);
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

 // Загружаем данные о товарах при загрузке страницы
 window.onload = loadProducts;
