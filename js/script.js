$(document).ready(function() {
    function updateTotalItems() {
        let totalSum = 0;
        $('#data-table tbody tr').each(function() {

            var sumValue = $(this).find('td:last').text();


            sumValue = sumValue.replace(/[^\d,.]/g, '').replace(',', '.');
            sumValue = parseFloat(sumValue);

            
            if (!isNaN(sumValue)) {
                totalSum += sumValue; 
            }
        });

        let formattedSum = totalSum.toLocaleString('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('.total-price p').text('Общий баланс: ' + formattedSum + ' ₽'); 
    }

    updateTotalItems();
});
