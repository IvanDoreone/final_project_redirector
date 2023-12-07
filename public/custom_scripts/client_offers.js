// Деактивация/Активация офферов
let elements = document.querySelectorAll('#form_control');
let buttons = document.querySelectorAll('#form_control button');
let divs = document.querySelectorAll('#div_info');

elements.forEach(element => {
    element.addEventListener("submit", function() {
    buttons.forEach(button => {
        if(button.getAttribute('id') == element.getAttribute('name')) {
const xhr = new XMLHttpRequest();

xhr.open("POST", "offers_control", true);
xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
id: element.getAttribute('name'),
todo: button.getAttribute('name_2')
};
// Отправляем запрос
xhr.send(JSON.stringify(resp));

// Обрабатываем событие изменения состояния запроса
xhr.onreadystatechange = function() {
// Проверяем, что запрос завершен успешно
if (xhr.readyState === 4 && xhr.status === 200) {
  // Получаем данные из ответа сервера
  console.log(xhr.response);
  const data = JSON.parse(xhr.responseText);
  //console.log(data.status);


   if(data.status == 'stopped') {
    button.innerText = 'активировать'
    button.setAttribute("class", "bg-success rounded text-center text-white");
    button.setAttribute("name_2", "activate");
    divs.forEach(div => {
        if(div.getAttribute('name') == button.getAttribute('id')) {
            div.innerText = 'stopped';
            div.setAttribute("class", "bg-warning rounded text-center");
        }
    })
  }
  if(data.status == 'active') {
    button.innerText = 'деактивировать'
    button.setAttribute("class", "bg-warning rounded text-center");
    button.setAttribute("name_2", "deactivate");
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
let buttons3 = document.querySelectorAll('#form_control button');
let trs = document.querySelectorAll('#tr_row');
console.log(trs);
//let divs = document.querySelectorAll('#div_info');

elements3.forEach(element => {
    element.addEventListener("submit", function() {
    buttons3.forEach(button => {
        if(button.getAttribute('id') == element.getAttribute('name')) {
        
const xhr = new XMLHttpRequest();
const url = element.getAttribute('action');
xhr.open("POST", 'offers_delete_ajax', true);
xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
offer_id: element.getAttribute('name'),

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
  console.log(data);


trs.forEach(element => {
if(element.getAttribute('name') == data) {
//element.innerHTML = '';
element.innerText = '';
}


})



   
  
}
}
}
    })

 });
});

// Отправка формы

let post_offer = document.querySelector('#post_offer');
let new_site_name = document.querySelector('#post_offer #site_name');
let new_site_uri = document.querySelector('#post_offer #site_uri');
let new_site_theme = document.querySelector('#post_offer #site_theme');
let new_link_text = document.querySelector('#post_offer #link_text');
let new_coast = document.querySelector('#post_offer #coast');
let div_errors = document.querySelector('#ajax_errors');
let new_row = document.querySelector('#new_row');
let body = document.querySelector('#body');
let table = document.querySelector('#table');


post_offer.addEventListener("submit", function() {
    div_errors.innerText = '';


const xhr = new XMLHttpRequest();

xhr.open("POST", "offers_post_new", true);
xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
new_site_name: new_site_name.value,
site_uri: new_site_uri.value,
new_site_theme: new_site_theme.value,
new_link_text: new_link_text.value,
new_coast: new_coast.value,
};

//console.log(resp);
// Отправляем запрос
xhr.send(JSON.stringify(resp));

// Обрабатываем событие изменения состояния запроса
xhr.onreadystatechange = function() {
// Проверяем, что запрос завершен успешно
if (xhr.readyState === 4 && xhr.status === 200) {
  // Получаем данные из ответа сервера
  //console.log(xhr.response);
new_site_name.value ='';
new_site_uri.value ='';
new_site_theme.value ='';
new_link_text.value ='';
new_coast.value ='';
  const data = JSON.parse(xhr.responseText);
  console.log(data);

  if(data.errors) {

    div_errors.setAttribute('class', 'alert alert-danger')
    for (let key in data.errors) {
if (data.errors.hasOwnProperty(key)) {
    div_errors.innerHTML += `<li>${data.errors[key]}</li>`
}
}
new_site_name.value ='';
new_site_uri.value ='';
new_site_theme.value ='';
new_link_text.value ='';
new_coast.value ='';
} else {

    //console.log(data);
    div_errors.setAttribute('class', '')
    let tr = document.createElement('tr');
    tr.setAttribute('id', `new_td${data.id}`)
    

    let aa = `
    <td id="new_td${data.id}"><span class="badge text-bg-danger">NEW</span></td>
    <td id="new_td${data.id}">${data.created_at}</td>
    <td id="new_td${data.id}">${data.site_name}</td>
    <td id="new_td${data.id}">
        <a href="${data.site_uri}" target="_blank" >${data.site_uri}</a>
    </td>
    <td id="new_td${data.id}">${data.link_text}</td>
    <td id="new_td${data.id}">
        <div id="div_info_new" name="${data.id}" class="bg-success rounded text-center text-white">${data.status}</div>
    </td>
    <td id="new_td${data.id}" data-field="subcriptops" data-sortable="true">${data.subscribs_amount}</td>
    <td id="new_td${data.id}">0</td>
    <td id="new_td${data.id}">
        <button style="width: 220px" type="button" name_2="deactivate" name="${data.id}" value="${data.id}" id="new_activate" class="bg-warning rounded text-center">деактивировать</button>
        <br>
        <button style="width: 220px" data-bs-dismiss="modal" type="button" name="${data.id}" value="${data.id}" id="new_delete" class="bg-danger rounded text-center text-white">удалить</button> 
    </td>
    
    `
    tr.innerHTML = aa;

    body.prepend(tr);

    //Удаление new offer
let new_del_buttons = document.querySelectorAll('#new_delete');

//let divs = document.querySelectorAll('#div_info'); 
new_del_buttons.forEach(new_del_button => {
        if(new_del_button.getAttribute('name') == data.id) {
            
            new_del_button.addEventListener('click', function() {
                console.log(new_del_button);
            let new_del_tr = document.querySelectorAll(`#new_td${data.id}`);
            console.log(new_del_tr);
            new_del_tr.forEach(element => {
                element.innerText='';
                element.innerHTML='';
            });
            /* let new_del_tt = document.querySelector(`new_tr${data.id}`);
            new_del_tt.innerText='';
            new_del_tt.innerHTML='';
*/
const xhr = new XMLHttpRequest();

xhr.open("POST", 'offers_delete_ajax', true);
xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
offer_id: new_del_button.getAttribute('name'),
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
}
} 

});
}
});


    //Activate/disactivate new offer
    let new_act_buttons = document.querySelectorAll('#new_activate');

//let divs = document.querySelectorAll('#div_info'); 
new_act_buttons.forEach(new_act_button => {
    if(new_act_button.getAttribute('name') == data.id) {
        
        new_act_button.addEventListener('click', function() {
            console.log(new_act_button);
        let new_div = document.querySelectorAll('#div_info');
        //console.log(new_del_tr);
        /* let new_del_tt = document.querySelector(`new_tr${data.id}`);
        new_del_tt.innerText='';
        new_del_tt.innerHTML='';
*/
const xhr = new XMLHttpRequest();

xhr.open("POST", 'offers_control', true);
xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
id: new_act_button.getAttribute('name'),
todo: new_act_button.getAttribute('name_2')
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
const obj = JSON.parse(data);
//console.log(obj); 
//console.log(obj.status); 
let divs_new = document.querySelectorAll('#div_info_new');


//console.log(data.status);

if(obj.status == 'stopped') {
//console.log(data.status);
    console.log(new_act_button);
    new_act_button.innerText = 'активировать'
    new_act_button.setAttribute("class", "bg-success rounded text-center text-white");
    new_act_button.setAttribute("name_2", "activate");
    console.log(divs_new);
    divs_new.forEach(div => {
        if(div.getAttribute('name') == new_act_button.getAttribute('name')) {
            console.log(div);

            div.innerText = 'stopped';
            div.setAttribute("class", "bg-warning rounded text-center");
        }
    })
  }
  if(obj.status == 'active') {
    new_act_button.innerText = 'деактивировать'
    new_act_button.setAttribute("class", "bg-warning rounded text-center");
    new_act_button.setAttribute("name_2", "deactivate");
    console.log(divs_new);
    divs_new.forEach(div => {
        if(div.getAttribute('name') == new_act_button.getAttribute('name')) {
            console.log(div);

            div.innerText = 'active';
            div.setAttribute("class", "bg-success rounded text-center text-white");
        }
    })

}
} 

}
});
        
}


});

}

}
}
})


