@extends('layout')
@section('title') Мои Офферы @endsection
@section('main content')
@if (Auth::user()->status == 'authorized')

<h2>Добавить оффер</h2>

@if($errors -> any())

<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $err )
<li>
    {{ $err }}
</li>
@endforeach
</ul>
</div>

@endif


<form id="post_offer" method="POST" action="#" onsubmit="event.preventDefault()">
    @csrf
<input type="text" name="site_name" id="site_name" class="form-control" placeholder="new_site_name: введите название сайта"><br>
<input type="text" name="site_uri" id="site_uri" class="form-control" placeholder="site_url: введите полный URL адрес страницы для перехода (с https://)"><br>
<input type="text" name="site_theme" id="site_theme" class="form-control" placeholder="new_theme: тематика сайта"><br>
<input type="text" name="link_text" id="link_text" class="form-control" placeholder="new_link_text: текст для ссылки (якорь)"><br>
<input type="number" name="coast" id="coast" class="form-control" placeholder="new_coast: стоимость перехода в руб. (от 1 до 100)"><br>
<button id ="send_button" type="submit" class="btn btn-success">Отправить offer</button>

</form>
<br>
<ul id="ul_errors">
    <div id="ajax_errors" ></div>
    </ul>

<h3>Мои Офферы:</h3>
<div class="alert alert-warning">
    Важно! Удалять можно только те офферы, на которых в данный момент нет подписок. Офферы на которые уже оформлена подписка удалить нельзя. Однако, Вы в любой момент можете
    их <b>ДЕАКТИВИРОВАТЬ</b> нажав на соответствующую кнопку. Всё просто!
</div>
    @if(!empty($offers))

    <div class="alert alert-info">
        <table class="table table-striped" id="table"
>
        <thead>
            <tr>
                <th>пп</th><th>Дата</th><th>Сайт</th><th>url</th><th>Якорь</th><th>Статус</th><th data-field="subcriptops" data-sortable="true">Подписчики</th><th>Кол-во Переходов всего</th><th>Управление</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>


        <tbody id="body">
            @php
            $num = 0;
            @endphp
            @foreach ($offers as $element)
            @if ($element->status != 'deleted')
            @php
            $num++;
            @endphp

            <tr id="tr_row" name="{{ $element->id }}">
                <td>{{ $num }}</td><td>{{ substr($element->created_at, 0,-9) }}</td><td>{{ $element->site_name }}</td>
                <td><a href="{{ $element->site_uri }}" target="_blank" >{{ $element->site_uri }}</a></td>
                <td>{{ $element->link_text }}<br><a href="#" data-bs-toggle="modal" data-bs-target="#myModal{{ $element->id }}">редактировать</a>

                      <!-- The Modal -->
                      <div class="modal" id="myModal{{ $element->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Редактировать текст ссылки</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="GET" action="offers/{{ $element->id }}">
                            <!-- Modal body -->
                            <div class="modal-body">
                            <input hidden type="text" name="offer_id" value = "{{ $element->id }}">
                            <input type="text" name="new_link_text" id="new_link_text" class="form-control" placeholder="{{ $element->link_text }}" value="{{ $element->link_text }}">
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Отправить на проверку</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    <noscript>
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Редактировать текст ссылки</h4>

                        </div>
                        <form method="GET" action="offers/{{ $element->id }}">
                        <!-- Modal body -->
                        <div >
                        <input hidden type="text" name="offer_id" value = "{{ $element->id }}">
                        <input type="text" name="new_link_text" id="new_link_text"  placeholder="{{ $element->link_text }}" value="{{ $element->link_text }}">
                        </div>

                        <!-- Modal footer -->
                        <div >
                          <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Отправить на проверку</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </noscript>

                </td>
                <td>

                    @if ($element->status == 'blocked')
                    <div name="{{ $element->id }}" id="div_info"  class="bg-danger rounded text-center text-white">blocked by admin</div>
                    @endif
                    @if ($element->status == 'stopped')
                    <div name="{{ $element->id }}" id="div_info"  class="bg-warning rounded text-center text-white">stopped by me</div>
                    @endif
                    @if ($element->status == 'active')
                    <div name="{{ $element->id }}" id="div_info"  class="bg-success rounded text-center text-white">active</div>
                    @endif
                </td>
                <td>
                    @if ($element->subscribs_amount > 0)
                    <a href="#" data-bs-toggle="modal" data-bs-target="#myModal_subscribers{{ $element->id }}">{{ $element->subscribs_amount }}</a>

<!-- The Modal -->
<div class="modal" id="myModal_subscribers{{ $element->id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Активные подписсики на офер сейчас </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <table class="table">
                <thead>

                <tr><th scope="col">пп</th><th scope="col">сайт</th><th scope="col">url</th><th scope="col">стоимость перехода</th><th scope="col">статус</th></tr>
                </thead>
                @php
                    $number = 1;
                @endphp
                @foreach ($subscribes as $subscrib)
                @if ($subscrib->offer_id == $element->id)
                <tr><td scope="row">{{ $number++ }}</td><td>{{ $subscrib->name }}</td><td><a href="{{ $subscrib->uri }}" target="_blank" >{{ $subscrib->uri }}</a></td><td>{{ $subscrib->coast }} руб.</td>
                    <td>
                        @if ($subscrib->status == 'active')
                        <div class="bg-success rounded text-center text-white">в_работе</div>
                        @else
                        <div class="bg-warning rounded text-center">остановлена</div>
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
        </div>

      </div>
    </div>
  </div>

    <noscript>
        <p>Активные подписсики на офер сейчас </p>
        <table class="table">
            <thead>

            <tr><th scope="col">пп</th><th scope="col">сайт</th><th scope="col">url</th><th scope="col">стоимость перехода</th><th scope="col">статус</th></tr>
            </thead>
            @php
                $number = 1;
            @endphp
            @foreach ($subscribes as $subscrib)
            @if ($subscrib->offer_id == $element->id)
            <tr><td scope="row">{{ $number++ }}</td><td>{{ $subscrib->name }}</td><td><a href="{{ $subscrib->uri }}" target="_blank" >{{ $subscrib->uri }}</a></td><td>{{ $subscrib->coast }} руб.</td>
                <td>
                    @if ($subscrib->status == 'active')
                    <div class="bg-success rounded text-center text-white">в_работе</div>
                    @else
                    <div class="bg-warning rounded text-center">остановлена</div>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </table>
    </noscript>
    @else
    <p>0</p>
    @endif
        </td>
                <td>
                    @foreach ($transitions as $transition)
                        @if ($transition->id == $element->id)
                            <a href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions{{ $element->id }}">{{ $transition->count }}</a>
                        @endif
                    @endforeach

                    <!-- The Modal -->
                <div class="modal" id="myModal_transitions{{ $element->id }}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Расходы по этому офферу, руб.</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <table class="table">
                                <thead>
                                <tr><th scope="col">сегодня: {{ date('d.m') }}</th><th scope="col">месяц: {{ date('m.Y') }}</th><th scope="col">год:{{ date('Y') }}</th><th scope="col">всего</th></tr>
                                </thead>
                                <tr>
                                    <td>
                                    @foreach ($transitionsday as $transitionday)
                                    @if ($transitionday->id == $element->id)
                                    {{ $transitionday->count}}
                                    @endif
                                    @endforeach
                                    </td>
                                    <td>
                                     @foreach ($transitionsmonth as $transitionmonth)
                                     @if ($transitionmonth->id == $element->id)
                                    {{ $transitionmonth->count}}
                                    @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach ($transitionsyear as $transitionyear)
                                    @if ($transitionyear->id == $element->id)
                                    {{ $transitionyear->count}}
                                    @endif
                                    @endforeach
                                    </td>
                                    <td>
                                        @foreach ($transitionsall as $transitionall)
                                        @if ($transitionall->id == $element->id)
                                        {{ $transitionall->count}}
                                        @endif
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                        </div>

                      </div>
                    </div>
                  </div>

                    <noscript>
                        @foreach ($transitions as $transition)
                        @if ($transition->id == $element->id)
                            <a href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions{{ $element->id }}">{{ $transition->count }}</a>
                        @endif
                    @endforeach
                    <table class="table">
                        <thead>
                        <tr><th scope="col">сегодня: {{ date('d.m') }}</th><th scope="col">месяц: {{ date('m.Y') }}</th><th scope="col">год:{{ date('Y') }}</th><th scope="col">всего</th></tr>
                        </thead>
                        <tr>
                            <td>
                            @foreach ($transitionsday as $transitionday)
                            @if ($transitionday->id == $element->id)
                            {{ $transitionday->count}}
                            @endif
                            @endforeach
                            </td>
                            <td>
                             @foreach ($transitionsmonth as $transitionmonth)
                             @if ($transitionmonth->id == $element->id)
                            {{ $transitionmonth->count}}
                            @endif
                            @endforeach
                            </td>
                            <td>
                            @foreach ($transitionsyear as $transitionyear)
                            @if ($transitionyear->id == $element->id)
                            {{ $transitionyear->count}}
                            @endif
                            @endforeach
                            </td>
                            <td>
                                @foreach ($transitionsall as $transitionall)
                                @if ($transitionall->id == $element->id)
                                {{ $transitionall->count}}
                                @endif
                                @endforeach
                            </td>
                        </tr>
                    </table>
                    </noscript>

                </td>
                <td id="delete">
                    <form id="form_control" onsubmit="event.preventDefault()" method="POST" action="offers/{{ $element->id }}" name="{{ $element->id }}">
                        @csrf
                        @method('PUT')
                        @if ($element->status === 'active')
                        <input hidden type="text" name="status" value = "active">
                        <button type="submit" name_2="deactivate" name="offers_id" value="{{ $element->id}}" id="{{ $element->id }}" class="bg-warning rounded text-center">деактивировать</button>
                        @endif
                        @if ($element->status === 'stopped')
                        <input hidden type="text" name="status" value = "notactive">
                        <button type="submit" name_2="activate" name="offers_id" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-success rounded text-center text-white">активировать</button>
                        @endif
                        @if ($element->status === 'blocked')
                        <input hidden type="text" name="status" value = "notactive">
                        <button disabled name_2="activate" type="submit" name="offers_id" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-success rounded text-center text-white">активировать</button>
                        @endif
                    </form>
                    <br>




                    <button @disabled($element->subscribs_amount > 0) style="width: 220px" data-bs-toggle="modal" data-bs-target="#myModal_delete{{ $element->id }}" type="button" name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">удалить</button>




                <!-- The Modal -->
            <div class="modal" id="myModal_delete{{ $element->id }}">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Это действие необратимо, уверены?</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="form_control2" onsubmit="event.preventDefault()"  method="POST" action="offers/{{ $element->id }}"  name="{{ $element->id }}">
                            @csrf
                            @method('DELETE')
                        <button data-bs-dismiss="modal" type="submit" name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">удалить</button>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                    </div>

                  </div>
                </div>
              </div>


            </td>


            </tr>

            @endif
            @endforeach
        </tbody>
        </table>

{{-- <script>const csrf = '{{ csrf_token() }}';</script>
<script src="custom_scripts\client_offers.js"></script> --}}
<script>
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
xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

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
xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

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
xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

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
xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

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
xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

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



</script>
</div>

@endif


</div>


@else
<div class="alert alert-danger">вы  не авторизованы! Запросите авторизацию</div>
@endif
@endsection



