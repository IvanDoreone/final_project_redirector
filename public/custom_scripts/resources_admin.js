$(document).ready(function() {
    // Initialize DataTable SORT
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
    "next": "Следующая1",
    "previous": "Предыдущая",
    "search": "Filter records:"
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
    targets: [3,6],
    }]
    
    });
    });

    // CONTROL Buttons
    
    let elements = document.querySelectorAll('#form_control');
    let buttons = document.querySelectorAll('#form_control button');
    let divs = document.querySelectorAll('#div_info');
    
    elements.forEach(element => {
            element.addEventListener("submit", function() {
            buttons.forEach(button => {
                if(button.getAttribute('id') == element.getAttribute('name')) {
      const xhr = new XMLHttpRequest();
    
      xhr.open("POST", "resources_admin", true);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
    
    let resp = {     // объект
      id: element.getAttribute('name'),
      todo: button.getAttribute('name')
    };
      // Отправляем запрос
      xhr.send(JSON.stringify(resp));
    
      // Обрабатываем событие изменения состояния запроса
      xhr.onreadystatechange = function() {
        // Проверяем, что запрос завершен успешно
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Получаем данные из ответа сервера
          const data = JSON.parse(xhr.responseText);
          console.log(data.status);
    
    
          if(data.status == 'not_approved') {
            button.innerText = 'разрешить'
            button.setAttribute("class", "bg-success rounded text-center text-white");
            button.setAttribute("name", "resource_to_start");
            divs.forEach(div => {
                if(div.getAttribute('name') == button.getAttribute('id')) {
                    div.innerText = 'not_approved';
                    div.setAttribute("class", "bg-warning rounded text-center");
                }
            })
          }
          if(data.status == 'approved') {
            button.innerText = 'блокировать'
            button.setAttribute("class", "bg-danger rounded text-center text-white");
            button.setAttribute("name", "resource_to_stop");
            divs.forEach(div => {
                if(div.getAttribute('name') == button.getAttribute('id')) {
                    div.innerText = 'approved';
                    div.setAttribute("class", "bg-success rounded text-center text-white");
                }
            })
          }
        }
      }
    }
    })
    
    });
    });