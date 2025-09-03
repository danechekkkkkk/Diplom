$(document).ready(function() {
    $('.delete-icon').on('click', function() {
        if (confirm('Вы действительно хотите удалить эту запись?')) {
            const id = $(this).data('id');

            $.post('vendor/consignment/delete_invoice.php', { id: id }, function() {
                alert('Запись успешно удалена');
                location.reload(); 
            }, 'json');
        }
    });
    let items = [];
    let totalSum = 0;
    $('#phone').mask('+7(999) 999-99-99');

    $('#openModal').on('click', function() {
        $('#myModal').show();
    });
    $('.close').on('click', function() {
        $('#myModal').hide();
    });

    $('#addRecordForm').on('submit', function(e) {
    e.preventDefault();

    const selectedOption = $('#name option:selected');
    const id = selectedOption.val(); 
    const name = selectedOption.data('name'); 
    const count = parseFloat($('#count').val());
    const price = parseFloat($('#price').val());
    const availableCount = parseFloat(selectedOption.data('count'));

    console.log("Количество: ", count);
    console.log("Введенное количество" ,availableCount)

    if (!selectedOption.length) {
        alert('Пожалуйста, выберите товар.');
        return;
    }

    if (!id || isNaN(count) || isNaN(price)) {
        alert('Пожалуйста, заполните все поля корректно.');
        return;
    }

    if (count > availableCount) {
            alert(`Недостаточно товара. Доступно: ${availableCount} шт.`);
            return;
        }
  

    const total = count * price;
    items.push({ id, name, count, price, total });

    totalSum += total;
    $('#totalSum').text(totalSum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

    $('#consignment-table tbody').append(`
        <tr>
            <td>${$('#consignment-table tbody tr').length + 1}</td>
            <td>${name}</td>
            <td>${count} шт.</td>
            <td>${price.toLocaleString('en-US', { minimumFractionDigits: 2 })} ₽</td>
            <td>${total.toLocaleString('en-US', { minimumFractionDigits: 2 })} ₽</td>
            <td>
                <img src="images/edit_data_icon.svg" class="edit-icon" alt="Редактировать" style='cursor:pointer;'>
            </td>
            <td>
                <img src="images/delete-icon.svg" class="delete-icon" alt="Удалить" style='cursor:pointer;'>
            </td>
        </tr>
    `);
    $('#name').val('');
    $('#count').val('');
    $('#price').val('');
    $('#myModal').hide();
});
    $('#consignment-table').on('click', '.edit-icon', function() {
        const row = $(this).closest('tr');
        const index = row.index();

        $('#editName').val(items[index].name);
        $('#editcount').val(items[index].count);
        $('#editPrice').val(items[index].price);

        $('#editModal').show();

        $('#editRecord').off('submit').on('submit', function(e) {
            e.preventDefault();

            const name = $('#editName').val().trim();
            const count = parseFloat($('#editcount').val());
            const price = parseFloat($('#editPrice').val());

            if (!name || isNaN(count) || isNaN(price)) {
                alert('Пожалуйста, заполните все поля корректно.');
                return;
            }

            const total = count * price;
            items[index] = { name, count, price, total };

            row.find('td:eq(1)').text(name);
            row.find('td:eq(2)').text(count + ' шт.');
            row.find('td:eq(3)').text(price.toLocaleString('en-US', { minimumFractionDigits: 2 }) + ' ₽');
            row.find('td:eq(4)').text(total.toLocaleString('en-US', { minimumFractionDigits: 2 }) + ' ₽');

            totalSum = items.reduce((sum, item) => sum + item.total, 0);
            $('#totalSum').text(totalSum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

            $('#editModal').hide();
        });
    });

    $('#consignment-table').on('click', '.delete-icon', function() {
        const row = $(this).closest('tr');
        const index = row.index();

        totalSum -= items[index].total; 
        items.splice(index, 1); 
        row.remove();


        $('#consignment-table tbody tr').each(function(i) {
            $(this).find('td:first').text(i + 1); 
        });

        $('#totalSum').text(totalSum.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    });

    $('#saveData').on('click', function() {
        const supplier = $('#supplier').val();
        const buyer = $('#buyer').val();
        const address = $('#address').val();
        const phone = $('#phone').val();
        const contact_person = $('#contact_person').val();

        $.ajax({
            url: 'vendor/consignment/save_data.php', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                supplier: supplier,
                buyer: buyer,
                address: address,
                phone: phone,
                contact_person: contact_person,
                tableData: items 
            }),
            success: function(response) {
    const result = JSON.parse(response);
    alert(result.message || 'Успешно сохранено!'); 
    if (result.status === 'success') {
        location.reload();
        $('#supplier').val('');
        $('#buyer').val('');
        $('#address').val('');
        $('#phone').val('');
        $('#contact_person').val('');
        items = [];
        totalSum = 0;
        $('#totalSum').text('0.00'); 
        $('#consignment-table tbody').empty(); 
    }
},

            error: function(xhr, status, error) {
                alert('Произошла ошибка: ' + error);
            }
        });
    });
});

       
