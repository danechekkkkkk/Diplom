document.addEventListener('DOMContentLoaded', function() {
    const editIcons = document.querySelectorAll('.edit-icon');
    const editModal = document.getElementById('editModal');
    const closeEditModal = document.getElementById('closeEditModal');

    editIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const art = this.getAttribute('data-art');
            const count = this.getAttribute('data-count');
            const salePrice = this.getAttribute('data-sale-price');

            const idInput = document.getElementById('id');
            const nameInput = document.getElementById('editName');
            const artInput = document.getElementById('editArt');
            const countInput = document.getElementById('editCount');
            const priceInput = document.getElementById('editPrice');

            if (idInput) idInput.value = id;
            if (nameInput) nameInput.value = name;
            if (artInput) artInput.value = art;
            if (countInput) countInput.value = count;
            if (priceInput) priceInput.value = salePrice;

            const editRecordForm = document.getElementById('editRecord');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'id';
            hiddenInput.value = id;
            editRecordForm.appendChild(hiddenInput);

            editModal.style.display = 'block';
        });
    });

    closeEditModal.addEventListener('click', function() {
        editModal.style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    };
});

$(document).ready(function() {
    
    $('.delete-icon').on('click', function() {
        const Id = $(this).data('id');
        if (confirm("Вы уверены, что хотите удалить эту запись?")) {
            $.ajax({
                url: 'vendor/warehouse/delete_warehouse.php',
                type: 'POST',
                data: { id: Id },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert('Запись успешно удалена.');
                        location.reload();
                    } else {
                        alert('Ошибка: ' + result.error);
                    }
                },
                error: function() {
                    alert('Ошибка при выполнении запроса.');
                }
            });
        }
    });

});

