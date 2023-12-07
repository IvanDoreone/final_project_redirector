//Удаление ресурсов
let elements3 = document.querySelectorAll('#form_control3');
let buttons3 = document.querySelectorAll('#form_control3 button');
let trs = document.querySelectorAll('#tr_row');
console.log(trs);
    //let divs = document.querySelectorAll('#div_info');

elements3.forEach(element => {
        element.addEventListener("submit", function() {
        buttons3.forEach(button => {
            if(button.getAttribute('id') == element.getAttribute('name')) {

    const xhr = new XMLHttpRequest();
    const url = element.getAttribute('action');
  xhr.open("POST", 'resource_delete_ajax', true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
  id: element.getAttribute('name'),
};
  // Отправляем запрос
  xhr.send(JSON.stringify(resp));

  // Обрабатываем событие изменения состояния запроса
  xhr.onreadystatechange = function() {
    // Проверяем, что запрос завершен успешно
    if (xhr.readyState === 4 && xhr.status === 200) {


    const data = JSON.parse(xhr.responseText);
    console.log(data);
trs.forEach(element => {
if(element.getAttribute('name') == data.id) {
element.innerText = '';
element.innerHTML = '';
}

})

    }
  }
}
        })

     });
});


   // Редактирование ресурса
    let forms = document.querySelectorAll('#form_control');
    let resourse_id = document.querySelector('#form_control #resourse_id');

    let buttons = document.querySelectorAll('#control_button');
    let urls = document.querySelectorAll('#url');
    let div_errors = document.querySelector('#ajax_errors');

    console.log(buttons);
    forms.forEach(form => {
        form.addEventListener("submit", function() {

            buttons.forEach(button => {
            if(button.getAttribute('name') == form.getAttribute('name')) {
                let curr_id = form.getAttribute('name');
                let new_uri = document.querySelector(`#form_control #new_uri${curr_id}`);
                let new_theme = document.querySelector(`#form_control #new_theme${curr_id}`);
                let new_coast = document.querySelector(`#form_control #new_coast${curr_id}`);
    //console.log(button);

                const xhr = new XMLHttpRequest();

        xhr.open("POST", "resources_control_ajax", true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrf);


        let resp = {     // объект
        resourse_id: form.getAttribute('name'),
        new_uri: new_uri.value,
        new_coast: new_coast.value,
        new_theme: new_theme.value,
    };

    xhr.send(JSON.stringify(resp));

// Обрабатываем событие изменения состояния запроса
xhr.onreadystatechange = function() {
  // Проверяем, что запрос завершен успешно
  if (xhr.readyState === 4 && xhr.status === 200) {
    // Получаем данные из ответа сервера
    //console.log(xhr.response);

    const data = JSON.parse(xhr.responseText);
    console.log(data);

if(data.errors) {

div_errors.setAttribute('class', 'alert alert-danger');
for (let key in data.errors) {
if (data.errors.hasOwnProperty(key)) {
//console.log(key + " -> " + data.errors[key]);
div_errors.innerHTML += `<li>${data.errors[key]}</li>`;
}
}

}
 else {
div_errors.setAttribute('class', '');
urls.forEach(url => {
        if(url.getAttribute('name') == form.getAttribute('name')) {
            url.innerHTML = `<a href="${data.new_uri}" target="_blank">${data.new_uri}</a>`;
        }
    })
}
}
}
}
})
})
})


// Отправка формы - новый ресурс

let post_resource2 = document.querySelector('#post_resource');
let name2 = document.querySelector('#name');
let uri2 = document.querySelector('#uri');
let theme2 = document.querySelector('#theme');
let coast2 = document.querySelector('#coast');
let div_errors2 = document.querySelector('#ajax_errors2');
let new_row = document.querySelector('#new_row');
let body = document.querySelector('#body');
let table = document.querySelector('#table');

post_resource2.addEventListener("submit", function() {
div_errors2.innerText = '';
const xhr = new XMLHttpRequest();

xhr.open("POST", "resourse_post_new_ajax", true);
xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {
    name: name2.value,
    uri: uri2.value,
    theme: theme2.value,
    coast: coast2.value,
};

// Отправляем запрос
xhr.send(JSON.stringify(resp));

// Обрабатываем событие изменения состояния запроса
xhr.onreadystatechange = function() {
  // Проверяем, что запрос завершен успешно
  if (xhr.readyState === 4 && xhr.status === 200) {
    // Получаем данные из ответа сервера
    const data = JSON.parse(xhr.responseText);
      console.log(data);


      if(data.errors) {

div_errors2.setAttribute('class', 'alert alert-danger')
for (let key in data.errors) {
if (data.errors.hasOwnProperty(key)) {
//console.log(key + " -> " + data.errors[key]);
div_errors2.innerHTML += `<li>${data.errors[key]}</li>`
}
}

} else {

    console.log(data);
        //table.setAttribute('id', 'table_new')
        let tr = document.createElement('tr');
        tr.setAttribute('id', `tr_new`)
        tr.setAttribute('name', `${data.id}`)

        let aa = `
        <td id="new_td${data.id}"><span class="badge text-bg-danger">NEW</span></td>
        <td id="new_td${data.id}">${data.created_at}</td>
        <td id="new_td${data.id}">${data.name}</td>
        <td id="new_td${data.id}">
            <a id="url2"name="${data.id}" href="${data.uri}" target="_blank" >${data.uri}</a>
        </td>
        <td id="new_td${data.id}">
            <div id="div_info_new" name="${data.id}" class="bg-success rounded text-center text-white">${data.status}</div>
        </td>
        <td id="new_td${data.id}">0</td>
        <td id="new_td${data.id}">0</td>
        <td id="new_td${data.id}">
            <button  type="button " name="resourse_id" value="${data.id}" id="${data.id}" class="btn btn-warning"data-bs-toggle="modal" data-bs-target="#myModalEdit_${data.id}" >редактировать</button>



<!-- The Modal -->
<div class="modal" id="myModalEdit_${data.id}">
<div class="modal-dialog">
<div class="modal-content">
<form  id="form_control2" onsubmit="event.preventDefault()" name="${data.id}" method="GET" action="my_resources/${data.id}/edit">
    @csrf
<!-- Modal Header -->
<div class="modal-header">

  <h4  class="modal-title">Редактировать ресурс</h4>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<!-- Modal body -->
<div class="modal-body">

<input id="resourse_id" hidden type="text" name="resourse_id" value="${data.id}">
<label for="new_uri">url ресурса</label>
<input type="text" name="new_uri" id="new_uri${data.id}" class="form-control" placeholder="${data.uri}" value="${data.uri}">
<label for="new_theme">тематики ресурса</label>
<input type="text" name="new_theme" id="new_theme${data.id}" class="form-control" placeholder="${data.theme}" value="${data.theme}">
<label for="new_coast">стоимость перехода, руб.</label>
<input type="number" name="new_coast" id="new_coast${data.id}" class="form-control" placeholder="${data.coast}" value="${data.coast}"><br>
</div>

<!-- Modal footer -->
<div  class="modal-footer">
  <button id="control_button2" name="${data.id}" type="submit" class="btn btn-success" data-bs-dismiss="modal">Подтвердить изменения</button>
</div>
</form>
</div>
</div>
</div>

</td>
<td>
    <form id="form_control4" onsubmit="event.preventDefault()" name="${data.id}" method="POST" action="my_resources/${data.id}">

                        <button type="submit" name_2="${data.id}" name="resourse_id" value="${data.id}" id="${data.id}" class="btn btn-danger">удалить</button>
                    </form>
</td>

        `
        tr.innerHTML = aa;

        body.prepend(tr);


        //Удаление новых ресурсов
let elements3 = document.querySelectorAll('#form_control4');
let buttons3 = document.querySelectorAll('#form_control4 button');
let trs = document.querySelectorAll('#tr_new');
console.log(trs);

elements3.forEach(element => {
        element.addEventListener("submit", function() {
        buttons3.forEach(button => {
            if(button.getAttribute('id') == element.getAttribute('name')) {

    const xhr = new XMLHttpRequest();
    const url = element.getAttribute('action');
  xhr.open("POST", 'resource_delete_ajax', true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

let resp = {     // объект
  id: element.getAttribute('name'),
};
  // Отправляем запрос
  xhr.send(JSON.stringify(resp));

  // Обрабатываем событие изменения состояния запроса
  xhr.onreadystatechange = function() {
    // Проверяем, что запрос завершен успешно
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Получаем данные из ответа сервера
      const data = JSON.parse(xhr.responseText);
console.log(data);
trs.forEach(element => {
if(element.getAttribute('name') == data.id) {
element.innerText = '';
element.innerHTML = '';
}

})

}
}
}
})

});
});

// Редактирование нового ресурса
    let forms = document.querySelectorAll('#form_control2');
    let resourse_id = document.querySelector('#form_control2 #resourse_id');

    let buttons = document.querySelectorAll('#control_button2');
    let urls = document.querySelectorAll('#url2');
    let div_errors = document.querySelector('#ajax_errors');

    console.log(buttons);
    forms.forEach(form => {
        form.addEventListener("submit", function() {

            buttons.forEach(button => {
            if(button.getAttribute('name') == form.getAttribute('name')) {
                let curr_id = form.getAttribute('name');
                let new_uri = document.querySelector(`#form_control2 #new_uri${curr_id}`);
                let new_theme = document.querySelector(`#form_control2 #new_theme${curr_id}`);
                let new_coast = document.querySelector(`#form_control2 #new_coast${curr_id}`);

    console.log(button);

                const xhr = new XMLHttpRequest();

        xhr.open("POST", "resources_control_ajax", true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrf);


        let resp = {     // объект
        resourse_id: form.getAttribute('name'),
        new_uri: new_uri.value,
        new_coast: new_coast.value,
        new_theme: new_theme.value,
    };

    xhr.send(JSON.stringify(resp));

// Обрабатываем событие изменения состояния запроса
xhr.onreadystatechange = function() {
  // Проверяем, что запрос завершен успешно
  if (xhr.readyState === 4 && xhr.status === 200) {
    // Получаем данные из ответа сервера

    const data = JSON.parse(xhr.responseText);
    console.log(data);

if(data.errors) {

div_errors.setAttribute('class', 'alert alert-danger');
for (let key in data.errors) {
if (data.errors.hasOwnProperty(key)) {
//console.log(key + " -> " + data.errors[key]);
div_errors.innerHTML += `<li>${data.errors[key]}</li>`;
}
}

}

 else {
div_errors.setAttribute('class', '');
urls.forEach(url => {
        if(url.getAttribute('name') == form.getAttribute('name')) {
            url.innerHTML = `<a href="${data.new_uri}" target="_blank">${data.new_uri}</a>`;
        }
    })
}
}
}

}
})
})
})


}
}

}
})
