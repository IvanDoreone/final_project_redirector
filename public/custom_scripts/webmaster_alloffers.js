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

// Подписка на  офферы
    let elements = document.querySelectorAll('#form_control');
    let buttons = document.querySelectorAll('#form_control button');
    let amounts = document.querySelectorAll('#amount');
    let options = document.querySelectorAll('#option');
    let full = document.querySelectorAll('#full');
    let buttons2 = document.querySelectorAll('#td_buttons button');

    //let divs = document.querySelectorAll('#div_info');

elements.forEach(element => {
        element.addEventListener("submit", function() {
            

        buttons.forEach(button => {
            if(button.getAttribute('name_2') == element.getAttribute('name')) {
                console.log(button);
  const xhr = new XMLHttpRequest();

  xhr.open("POST", "offer_subscribe_ajax", true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

  let select = document.querySelectorAll('#select_offer');
  let selected_resource = '';
  select.forEach(sel => {
    if(sel.getAttribute('name_2') == element.getAttribute('name')) {
        selected_resource = sel.value
    }
    
  })

let resp = {     // объект
    offer_uri_id: button.getAttribute('offer_uri_id'),
    offer_uri: button.getAttribute('offer_uri'),
    offer_coast: button.getAttribute('offer_coast'),
    select_offer: selected_resource,
};
  // Отправляем запрос
    xhr.send(JSON.stringify(resp));
  

  // Обрабатываем событие изменения состояния запроса
  xhr.onreadystatechange = function() {
    // Проверяем, что запрос завершен успешно
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Получаем данные из ответа сервера
      
      const data = JSON.parse(xhr.responseText);

      //console.log(data);

      amounts.forEach(amount => {
if(amount.getAttribute('name') == element.getAttribute('name')) {
    amount.innerText = data.resp[0].subscribs_amount;
}
      })
    let sub_id = element.getAttribute('name');
    let info_sub = document.querySelector(`#info_sub${sub_id}`);
    info_sub.innerHTML = 'подписан <p><a href="my_subscribes">перейти к подпискам</a></p>';



    options.forEach(option => {
if(option.getAttribute('name') == element.getAttribute('name') && option.getAttribute('name_2') == data.resp[0].donor_id) {
    //console.log(option);


    option.innerText = `ресурс уже подписан:  ${data.resp[0].uri}`;
    option.setAttribute("disabled", "true");  
     let select = document.querySelectorAll('#select_offer');
    select.forEach(option => {
        option.value = '-- Выберите ресурс --URL --';

    }) 
}
})

//console.log(data);
let r = element.getAttribute('name');
let keys = Object.keys(data.count_subscribes);
let values = Object.values(data.count_subscribes);
buttons2.forEach(button => {
if(button.getAttribute('name_3') == element.getAttribute('name') && data.count[0].count == values[keys.indexOf(r)]) {
    button.setAttribute('disabled','true');
    button.innerText='подписано!';
}
})    
}
}
}
})

});
});



