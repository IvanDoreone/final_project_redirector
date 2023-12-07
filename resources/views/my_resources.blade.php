@extends('layout')
@section('title') Мои Ресурсы @endsection
@section('main content')

@if (Auth::user()->status == 'authorized' && Auth::user()->role == 'web_master')

<h3>Добавить ресурс</h3>

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
<ul id="ul_errors2"><div id="ajax_errors2" ></div></ul>
<form id="post_resource" method="POST" action="#" onsubmit="event.preventDefault()">
    @csrf
<input type="text" name="name" id="name" class="form-control" placeholder="NAME: введите название сайта"><br>
<input type="text" name="uri" id="uri" class="form-control" placeholder="URL: введите адрес страницы для размещения рекламной ссылки"><br>
<input type="text" name="theme" id="theme" class="form-control" placeholder="THEME: тематика сайта: вводите через запятую (,)"><br>
<input type="number" name="coast" id="coast" class="form-control" placeholder="COAST: стоимость перехода в руб (от 1 до 10000)"><br>
<button type="submit" class="btn btn-success">Зарегистрировать ресурс</button>

</form>

<h3>Мои ресурсы</h3>
<div class="alert alert-warning">
    Важно! Ресурсы на которые вы оформили подписку нельзя удалять и редактировать. Сначала перейдите в раздел Мои Подписки для отмены подписок.
</div>
<ul id="ul_errors"><div id="ajax_errors" ></div></ul>
    @if(!empty($resource))
    <div class="alert alert-info overflow-auto">
        <table class="table  table-striped" id="table">
        <thead>
            <tr>
                <th>пп</th><th>Дата добавления</th><th>Сайт</th><th>url</th><th>Статус</th><th data-field="subcribes" data-sortable="true">Подписки</th><th>Переходы всего</th><th>Редактировать</th><th>Удалить</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
        <tbody id="body">
            @php
            $num = 0;
            @endphp
            @foreach ($resource as $element)
            @if ($element->status != 'deleted')
            @php
            $num++;
            @endphp


            <tr id="tr_row" name="{{ $element->id }}"><td>{{$num}}</td><td>{{ substr($element->created_at, 0,-9) }}</td><td>{{ $element->name }}</td>
                <td id="url" name="{{ $element->id }}"><a href="{{ $element->uri }}" target="_blank" >{{ $element->uri }}</a></td>
                <td>
                    @if ($element->status == 'approved')
                    <div class="bg-success rounded text-center text-white">approved</div>
                    @else
                    <div class="bg-danger rounded text-center text-white">blocked by admin</div>
                    @endif

                </td>
                <td>
                    @if ($element->subscribs_amount > 0)


                    <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_subscribes_{{ $element->id }}">{{ $element->subscribs_amount }}</a>

<!-- The Modal -->
<div class="modal" id="myModal_subscribes_{{ $element->id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content overflow-auto">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">подписки на этом ресурсе</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">


            <table class="table">
                <thead>

                <tr><th scope="col">пп</th><th scope="col">сайт</th><th scope="col">url</th><th scope="col">стоимость перехода</th><th scope="col">статус</th></tr>
                </thead>
                @php
                    $number = 1
                @endphp
                @foreach ($my_subscribes as $subscrib)
                @if ($subscrib->donor_id == $element->id)
                <tr><td scope="row">{{ $number++ }}</td><td>{{ $subscrib->site_name }}</td><td><a href="{{ $subscrib->site_uri }}" target="_blank" >{{ $subscrib->site_uri }}</a></td><td>{{ $subscrib->coast }} руб.</td>
                    <td>
                        @if ($subscrib->status == 'active')
                        <div class="bg-success rounded text-center text-white">в_работе</div>
                        @else
                        <div class="bg-warning rounded text-center">остановлена_клиентом</div>
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
        <p>мои подписки на этом URL</p>
        <table class="table">
            <thead>

            <tr><th scope="col">пп</th><th scope="col">сайт</th><th scope="col">url</th><th scope="col">стоимость перехода</th></tr>
            </thead>
            @php
                $number = 1
            @endphp
            @foreach ($my_subscribes as $subscrib)
            @if ($subscrib->donor_id == $element->id)
            <tr><td scope="row">{{ $number++ }}</td><td>{{ $subscrib->site_name }}</td><td><a href="{{ $subscrib->site_uri }}" target="_blank" >{{ $subscrib->site_uri }}</a></td><td>{{ $subscrib->coast }} руб.</td></tr>
            @endif
            @endforeach
        </table>
    </noscript>
    @else
    0
    @endif
    </td>
                <td>
                        @foreach ($my_transitions as $transition)
                            @if ($transition->id == $element->id)
                                {{ $transition->count }}
                                @else
                                0
                            @endif
                        @endforeach
                </td>
                <td><button @disabled($element->subscribs_amount > 0) type="button " name="resourse_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-warning"data-bs-toggle="modal" data-bs-target="#myModalEdit_{{ $element->id }}" >редактировать</button>



                            <!-- The Modal -->
                      <div class="modal" id="myModalEdit_{{ $element->id }}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <form  id="form_control" onsubmit="event.preventDefault()" name="{{ $element->id }}" method="GET" action="my_resources/{{ $element->id }}/edit">
                                @csrf
                            <!-- Modal Header -->
                            <div class="modal-header">

                              <h4  class="modal-title">Редактировать ресурс</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">

                            <input id="resourse_id" hidden type="text" name="resourse_id" value="{{ $element->id }}">
                            <label  for="new_uri">url ресурса</label>
                            <input type="text" name="new_uri" id="new_uri{{ $element->id }}" class="form-control" placeholder="{{ $element->uri }}" value="{{ $element->uri }}">
                            <label for="new_theme">тематики ресурса</label>
                            <input type="text" name="new_theme" id="new_theme{{ $element->id }}" class="form-control" placeholder="{{ $element->theme }}" value="{{ $element->theme }}">
                            <label for="new_coast">стоимость перехода, руб.</label>
                            <input type="number" name="new_coast" id="new_coast{{ $element->id }}" class="form-control" placeholder="coast" value="{{ $element->coast }}"><br>
                            </div>

                            <!-- Modal footer -->
                            <div  class="modal-footer">
                              <button id="control_button" name="{{ $element->id }}" type="submit" class="btn btn-success" data-bs-dismiss="modal">Подтвердить изменения</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>

                        <noscript>
                          <h4 class="modal-title">Редактировать </h4>
                          <input hidden type="text" name="resourse_id" value = "{{ $element->id }}">
                          <input type="text" name="new_uri" id="new_uri{{ $element->id }}" class="form-control" placeholder="{{ $element->uri }}" value="{{ $element->uri }}">
                          <input type="text" name="new_theme" id="new_theme{{ $element->id }}" class="form-control" placeholder="{{ $element->theme }}" value="{{ $element->theme }}">
                          <input type="number" name="new_coast" id="new_coast{{ $element->id }}" class="form-control" placeholder="coast" value="{{ $element->coast }}"><br>
                          <button @disabled($element->subscribs_amount > 0) type="submit" class="btn btn-success" data-bs-dismiss="modal">Отправить на проверку</button>
                        </noscript>

                        </form>
                      </div>
                    </div>
                  </div>

                    </form>
                </td>
                <td>
                    <form id="form_control3" onsubmit="event.preventDefault()" name="{{ $element->id }}" method="POST" action="my_resources/{{ $element->id }}">
                        @csrf
                        @method('DELETE')
                        <button @disabled($element->subscribs_amount > 0) type="submit" name_2="{{ $element->id }}" name="resourse_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-danger">удалить</button>
                    </form>
                </td>

            </tr> <!--ряд с ячейками тела таблицы-->

            @endif
            @endforeach

        </tbody>
        </table>

        </div>

    @endif



    <script>const csrf = '{{ csrf_token() }}';</script>
    <script src="custom_scripts\webmaster_resources.js"></script>



</div>

@else
<div class="alert alert-danger">вы  не авторизованы! Запросите авторизацию</div>
@endif
@endsection
