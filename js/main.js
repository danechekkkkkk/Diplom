document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('myModal');
    const openModalButton = document.getElementById('addBtn');
    const closeModalButton = document.querySelector('.close');

    // Открытие модального окна
    openModalButton.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    // Закрытие модального окна
    closeModalButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Закрытие модального окна при нажатии вне его области
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
