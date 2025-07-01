document.addEventListener('DOMContentLoaded', function() {
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
  
  // Анимация для блока "Только лучшие пироги"
  const bestPiesBlock = document.getElementById('best-pies-block');
  
  if (bestPiesBlock) {
    const animationArea = bestPiesBlock.closest('.element-2'); // Находим родительский контейнер
    if (!animationArea) return;
    
    const maxOffset = 110; // Максимальное смещение в пикселях
    let animationTriggered = false;
    let startPosition = 0;
    
    // Функция для обработки скролла
    function handleScroll() {
      const rect = animationArea.getBoundingClientRect();
      const windowHeight = window.innerHeight;
      const windowCenter = windowHeight / 2;
      
      // Если блок в области видимости
      if (rect.top < windowHeight && rect.bottom > 0) {
        // Вычисляем прогресс скролла (0-1)
        const scrollPosition = window.scrollY || window.pageYOffset;
        const elementTop = animationArea.offsetTop;
        const elementHeight = animationArea.offsetHeight;
        
        // Нормализованное значение от 0 до 1
        let scrollProgress = (scrollPosition - elementTop + windowCenter) / elementHeight;
        scrollProgress = Math.min(1, Math.max(0, scrollProgress));
        
        // Применяем смещение
        const offset = scrollProgress * maxOffset;
        bestPiesBlock.style.transform = `translateY(${offset}px)`;
        
        animationTriggered = true;
      } else if (animationTriggered) {
        // Сброс анимации, если блок вышел за пределы видимости
        bestPiesBlock.style.transform = 'translateY(0)';
      }
    }
    
    // Оптимизация производительности с requestAnimationFrame
    let ticking = false;
    window.addEventListener('scroll', function() {
      if (!ticking) {
        window.requestAnimationFrame(function() {
          handleScroll();
          ticking = false;
        });
        ticking = true;
      }
    });
    
    // Инициализация начальной позиции
    window.addEventListener('load', function() {
      startPosition = bestPiesBlock.getBoundingClientRect().top;
    });
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
});