document.addEventListener("DOMContentLoaded", function() {
    let sortOrder = 'asc';  

    document.getElementById('sortBtn').addEventListener('click', function(event) {
        event.preventDefault(); 

        const table = document.getElementById('consignment-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr')); 

        rows.sort((a, b) => {
            const aCount = parseInt(a.cells[3].textContent); 
            const bCount = parseInt(b.cells[3].textContent);
            return sortOrder === 'asc' ? aCount - bCount : bCount - aCount; 
        });

        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));

      
        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
    });
});
