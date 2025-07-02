// Получаем кнопку
const scrollToTopButton = document.getElementById('scrollToTop');

// Показываем кнопку при прокрутке вниз
window.onscroll = function () {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    scrollToTopButton.style.display = "block";
  } else {
    scrollToTopButton.style.display = "none";
  }
};

// Прокрутка вверх при нажатии на кнопку
scrollToTopButton.onclick = function () {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};


// Эффект волны для кнопок (остается без изменений)
const buttons = document.querySelectorAll('.wave-button');
buttons.forEach(button => {
  button.addEventListener('click', function (e) {
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


document.addEventListener('DOMContentLoaded', function () {
  const phoneInput = document.querySelector('input[name="phone"]');

  phoneInput.addEventListener('input', function (e) {
    let value = this.value.replace(/[^\d+]/g, '');

    // Автоматически добавляем +7 если начинаем с цифры
    if (/^\d/.test(value)) {
      value = '+7' + value;
    }

    // Ограничение длины
    if (value.length > 12) {
      value = value.substring(0, 12);
    }

    this.value = value;
  });
});
