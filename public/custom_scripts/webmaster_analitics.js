$(document).ready(function() {
    // Initialize DataTable
    $('#table').DataTable({
"language": {
"lengthMenu": "Показывать _MENU_ записей на странице",
"zeroRecords": "Ничего не найдено",
"info": "Страница _PAGE_ из _PAGES_",
"infoEmpty": "Нет записей для отображения",
"infoFiltered": "(отфильтровано из _MAX_ записей)",
"paginate": {
"first": "Первая",
"last": "Последняя",
"next": "Следующая",
"previous": "Предыдущая"
}
},
language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ru.json',
    },
"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Все"]],
"pageLength": 25,
    paging: true, // Enable pagination
    searching: true, // Enable search
    ordering: true, // Enable sorting
    info: true, // Show information
    lengthChange: true, // Disable the "Show X entries" dropdown
    columnDefs: [{
    orderable: false,
    targets: [3],
    }]

    });
    });
    
    console.log('laravel is cool!');