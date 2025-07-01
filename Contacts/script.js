document.addEventListener('DOMContentLoaded', function() {
    // Прокрутка вверх
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

    // Обработка формы
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.querySelector('.text-wrapper-5').textContent;
        
        // Показываем статус отправки
        submitBtn.disabled = true;
        submitBtn.querySelector('.text-wrapper-5').textContent = 'Отправка...';
        
        // Отправка формы через Fetch API
        fetch(form.action, {
            method: form.method,
            body: new FormData(form)
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            }
            return response;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.querySelector('.text-wrapper-5').textContent = originalBtnText;
        });
    });
    
    // Очистка формы при успешной отправке
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') && urlParams.get('status') === 'success') {
        document.getElementById('feedbackForm').reset();
    }
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


  document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('feedbackForm');
  const emailInput = document.getElementById('email');
  const emailError = document.getElementById('email-error');
  const nameError = document.getElementById('name-error');
  const messageError = document.getElementById('message-error');

  // Регулярные выражения для валидации
  const emailRegex = /^[a-zA-Z0-9._-]+@(gmail\.com|mail\.ru|yandex\.ru)$/;

  // Функция валидации email
  function validateEmail() {
    if (!emailRegex.test(emailInput.value)) {
      emailError.textContent = 'Используйте @gmail.com, @mail.ru или @yandex.ru';
      return false;
    }
    emailError.textContent = '';
    return true;
  }

  // Проверка заполненности полей
  function validateField(input, errorElement, fieldName) {
    if (input.value.trim() === '') {
      errorElement.textContent = `Поле "${fieldName}" обязательно для заполнения`;
      return false;
    }
    errorElement.textContent = '';
    return true;
  }

  // Обработчики событий
  emailInput.addEventListener('blur', validateEmail);
  document.getElementById('name').addEventListener('blur', () => 
    validateField(document.getElementById('name'), nameError, 'Имя'));
  document.getElementById('message').addEventListener('blur', () => 
    validateField(document.getElementById('message'), messageError, 'Сообщение'));

  // Отправка формы
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Валидация перед отправкой
    const isEmailValid = validateEmail();
    const isNameValid = validateField(document.getElementById('name'), nameError, 'Имя');
    const isMessageValid = validateField(document.getElementById('message'), messageError, 'Сообщение');
    
    if (!isEmailValid || !isNameValid || !isMessageValid) return;

    // Отправка через Fetch API
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.querySelector('.text-wrapper-5').textContent;
    
    submitBtn.disabled = true;
    submitBtn.querySelector('.text-wrapper-5').textContent = 'Отправка...';
    
    fetch('send_email.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Показываем сообщение об успехе
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.textContent = 'Сообщение успешно отправлено!';
        form.prepend(successDiv);
        form.reset();
      } else {
        // Показываем ошибки
        alert('Ошибка отправки: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      const successDiv = document.createElement('div');
      successDiv.className = 'success-message';
      successDiv.textContent = 'Сообщение успешно отправлено!';
      form.prepend(successDiv);
      form.reset();
    })
    .finally(() => {
      submitBtn.disabled = false;
      submitBtn.querySelector('.text-wrapper-5').textContent = originalText;
    });
  });
});
