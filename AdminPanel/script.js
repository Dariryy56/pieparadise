document.addEventListener('DOMContentLoaded', () => {
    // Функция для прокрутки вверх
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

    // Инициализация модального окна
    const modal = document.getElementById('editModal');
    const closeModal = document.querySelector('.close-modal');
    const editForm = document.getElementById('editForm');
    const formFields = document.getElementById('formFields');
    
    if (closeModal) {
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Обработчики для кнопок действий
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.dataset.table;
            const action = this.classList.contains('add') ? 'add' : 
                          this.classList.contains('edit') ? 'edit' : 'delete';
            
            const tableCard = this.closest('.table-card');
            let selectedId = null;
            
            // Получаем ID выбранной строки (если есть)
            const selectedRow = tableCard.querySelector('.selected-row');
            if (selectedRow) {
                selectedId = selectedRow.querySelector('td:first-child').textContent;
            }

            // Заполняем скрытые поля формы
            document.getElementById('modalTable').value = table;
            document.getElementById('modalAction').value = action;
            
            if (action === 'edit' || action === 'delete') {
                if (!selectedId) {
                    alert('Пожалуйста, выберите запись для ' + (action === 'edit' ? 'редактирования' : 'удаления'));
                    return;
                }
                document.getElementById('modalId').value = selectedId;
            }

            // Заполняем модальное окно в зависимости от действия
            formFields.innerHTML = '';
            
            if (action === 'add' || action === 'edit') {
                fetch(`../api/get_table_structure.php?table=${table}`)
                    .then(response => response.json())
                    .then(columns => {
                        columns.forEach(col => {
                            if (col.Field !== 'id') {
                                const value = (action === 'edit' && selectedRow) ? 
                                    selectedRow.querySelector(`td[data-column="${col.Field}"]`).textContent : '';
                                
                                // Добавляем атрибут required для всех полей
                                formFields.innerHTML += `
                                    <div class="form-group">
                                        <label for="${col.Field}">${col.Field}</label>
                                        <input type="text" id="${col.Field}" 
                                               name="data[${col.Field}]" 
                                               value="${value}"
                                               placeholder="${col.Type}"
                                               required>
                                    </div>
                                `;
                            }
                        });
                        modal.style.display = 'flex';
                    });
            } else if (action === 'delete') {
                formFields.innerHTML = `
                    <p>Вы уверены, что хотите удалить запись с ID ${selectedId}?</p>
                    <input type="hidden" name="id" value="${selectedId}">
                `;
                modal.style.display = 'flex';
            }
        });
    });

    // Выделение строк таблицы
    document.querySelectorAll('.admin-table tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            // Снимаем выделение со всех строк
            this.closest('table').querySelectorAll('tr').forEach(r => {
                r.classList.remove('selected-row');
            });
            
            // Выделяем текущую строку
            this.classList.add('selected-row');
            
            // Помечаем ячейки для поиска данных
            const cells = this.querySelectorAll('td');
            const headers = this.closest('table').querySelectorAll('th');
            cells.forEach((cell, index) => {
                cell.dataset.column = headers[index].textContent;
            });
        });
    });

    // Обработка отправки формы
    if (editForm) {
        editForm.addEventListener('submit', (e) => {
            // Проверяем валидность формы перед отправкой
            if (!editForm.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                alert('Пожалуйста, заполните все обязательные поля!');
                return;
            }
            
            const formData = new FormData(editForm);
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Ошибка сервера');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка: ' + error.message);
            });
        });
    }

    // Регулировка положения футера
    function adjustFooterPosition() {
        const tablesContainer = document.querySelector('.tables-container');
        const footer = document.querySelector('.view-12');
        
        if (!tablesContainer || !footer) return;
        
        const containerHeight = tablesContainer.offsetHeight;
        const minTop = 800;
        footer.style.top = `${containerHeight + minTop}px`;
        document.querySelector('.div').style.height = `${containerHeight + minTop + 455}px`;
    }

    adjustFooterPosition();
    window.addEventListener('resize', adjustFooterPosition);
});