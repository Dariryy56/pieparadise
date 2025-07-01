
    // Получаем кнопку
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



// Добавьте этот код в конец файла
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('input[name="phone"]');
    
    phoneInput.addEventListener('input', function(e) {
        // Оставляем только цифры и плюс
        let value = this.value.replace(/[^\d+]/g, '');
        
        // Обеспечиваем формат +7 в начале
        if (!value.startsWith('+7') && value.length > 0) {
            value = '+7' + value.replace(/\D/g, '');
        }
        
        // Ограничиваем длину (1 символ "+" + 11 цифр)
        if (value.length > 12) {
            value = value.substring(0, 12);
        }
        
        this.value = value;
    });

    // Валидация при отправке формы
    document.querySelector('form').addEventListener('submit', function(e) {
        const phoneValue = phoneInput.value;
        if (!/^\+7\d{10}$/.test(phoneValue)) {
            e.preventDefault();
            alert('Телефон должен быть в формате: +7XXXXXXXXXX (11 цифр после +)');
        }
    });
    });
