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

    // Валидация формы
    const form = document.getElementById('feedbackForm');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const nameError = document.getElementById('name-error');
    const messageError = document.getElementById('message-error');

    const emailRegex = /^[a-zA-Z0-9._-]+@(gmail\.com|mail\.ru|yandex\.ru|mpt\.ru)$/;

    function validateEmail() {
        if (!emailRegex.test(emailInput.value)) {
            emailError.textContent = 'Используйте @gmail.com, @mail.ru или @yandex.ru';
            return false;
        }
        emailError.textContent = '';
        return true;
    }

    function validateField(input, errorElement, fieldName) {
        if (input.value.trim() === '') {
            errorElement.textContent = `Поле "${fieldName}" обязательно для заполнения`;
            return false;
        }
        errorElement.textContent = '';
        return true;
    }

    // Валидация при потере фокуса
    emailInput.addEventListener('blur', validateEmail);
    document.getElementById('name').addEventListener('blur', () => 
        validateField(document.getElementById('name'), nameError, 'Имя'));
    document.getElementById('message').addEventListener('blur', () => 
        validateField(document.getElementById('message'), messageError, 'Сообщение'));

    // Обработка отправки формы
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const isEmailValid = validateEmail();
        const isNameValid = validateField(document.getElementById('name'), nameError, 'Имя');
        const isMessageValid = validateField(document.getElementById('message'), messageError, 'Сообщение');

        if (!isEmailValid || !isNameValid || !isMessageValid) {
            return;
        }

        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.querySelector('.text-wrapper-5').textContent;

        submitBtn.disabled = true;
        submitBtn.querySelector('.text-wrapper-5').textContent = 'Отправка...';

        fetch('send_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети');
            }
            return response.json();
        })
        .then(data => {
           // В блоке успешной отправки
if (data.success) {
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        Сообщение успешно отправлено!`;
    
    const oldSuccess = form.querySelector('.success-message');
    if (oldSuccess) oldSuccess.remove();
    
    form.prepend(successDiv);
    form.reset(); // Очистка полей формы
    
    // Прячем сообщение через 5 секунд
    setTimeout(() => {
        successDiv.remove();
    }, 5000);

            } else {
                alert('Ошибка: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при отправке. Пожалуйста, попробуйте ещё раз.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.querySelector('.text-wrapper-5').textContent = originalText;
        });
    });
});