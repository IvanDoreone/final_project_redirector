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
    
    
    let buttons = document.querySelectorAll('#select');
    let buttons_modal = document.querySelectorAll('#coppy_butt');
    console.log(buttons_modal);

    buttons.forEach(function(button) {
        button.onclick = () => {
    var name = button.getAttribute('name');

    
    var textToCopy = document.getElementById('copy' + name);

     //if (id = name) {
    //select the text in the text box
     textToCopy.select('link');
     //copy the text to the clipboard
     //document.execCommand("copy");
     window.navigator.clipboard.writeText(textToCopy.value);
     

    //alert(textToCopy.getAttribute('link') + ' ссылка скопирована! ');
    //}

    buttons_modal.forEach(function(button_modal) {
        if (button_modal.getAttribute('name') == name) {
            console.log(button_modal);

            button_modal.click();
        }
     })
        }})


// Деактивация/Активация офферов
let elements = document.querySelectorAll('#form_control');
    let buttons_control = document.querySelectorAll('#form_control button');
    let divs = document.querySelectorAll('#div_info');

elements.forEach(element => {
        element.addEventListener("submit", function() {
            buttons_control.forEach(button => {
            if(button.getAttribute('name_2') == element.getAttribute('name')) {
                console.log(button.getAttribute('name_2'));
                console.log(button.getAttribute('name'));

  const xhr = new XMLHttpRequest();

  xhr.open("POST", "control_subscribes_ajax", true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
  id: button.getAttribute('name_2'),
  todo: button.getAttribute('name')
};
  // Отправляем запрос
  xhr.send(JSON.stringify(resp));

  // Обрабатываем событие изменения состояния запроса
  xhr.onreadystatechange = function() {
    // Проверяем, что запрос завершен успешно
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Получаем данные из ответа сервера
      //console.log(xhr.response);
      const data = JSON.parse(xhr.responseText);
      console.log(data);


        if(data.status == 'stopped') {
        button.innerText = 'Возобновить'
        button.setAttribute("class", "bg-success rounded text-center text-white");
        button.setAttribute("name", "to_active");
        divs.forEach(div => {
            if(div.getAttribute('name') == button.getAttribute('id')) {
                div.innerText = 'stopped';
                div.setAttribute("class", "bg-warning rounded text-center");
            }
        })
      }
      if(data.status == 'active') {
        button.innerText = 'Остановить'
        button.setAttribute("class", "bg-warning rounded text-center");
        button.setAttribute("name", "to_stopped");
        divs.forEach(div => {
            if(div.getAttribute('name') == button.getAttribute('id')) {
                div.innerText = 'active';
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


//Удаление Офферов
let elements3 = document.querySelectorAll('#form_control2');
let buttons3 = document.querySelectorAll('#form_control2 button');
let trss = document.querySelectorAll('#tr_row_tr');
//console.log(trs);

elements3.forEach(element => {
        element.addEventListener("submit", function() {
        buttons3.forEach(button => {
            if(button.getAttribute('name_2') == element.getAttribute('name')) {
            
    const xhr = new XMLHttpRequest();
    const url = element.getAttribute('action');
  xhr.open("POST", 'my_subscribes_delete_ajax', true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
  id: button.getAttribute('name_2'),
  todo: button.getAttribute('name'),

};
  // Отправляем запрос
  xhr.send(JSON.stringify(resp));

  // Обрабатываем событие изменения состояния запроса
  xhr.onreadystatechange = function() {
    // Проверяем, что запрос завершен успешно
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Получаем данные из ответа сервера
      //console.log(xhr.response);
      const data = xhr.responseText;
      //console.log(data);

trss.forEach(elem => {
if(elem.getAttribute('name') === data) {
    console.log(elem);
//console.log(data);

//elem.setAttribute('id', 'new_id');

elem.innerText = '';
}


})  
 
    }
  }
}
        })

     });
});
 





