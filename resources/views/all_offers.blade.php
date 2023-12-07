@extends('layout')
@section('title') Все офферы @endsection
@section('main content')
@if (Auth::user()->status == 'authorized' && Auth::user()->role == 'web_master')
    <h2>Все активные офферы</h2>

    @if(!empty($offers))

    <div class="alert alert-info overflow-auto">
        <table class="table  table-striped" id="table"
        data-search="true"
        data-show-columns="true"
        data-show-multi-sort="true"
        data-sort-priority='[{"sortName": "date","sortOrder":"desc"},{"sortName":"subcriptops","sortOrder":"desc"}]'
        data-url="json/data3.json">
        <thead>
            <tr>
                <th>пп</th><th>Сайт</th><th>url</th><th>Якорь</th><th>Стоимость перехода</th><th data-field="subcriptops" data-sortable="true">Всего подписок</th><th>Статус оффера</th><th>Статус моей подписки</th><th>Изменить статус</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
            @foreach ($offers as $element)


            <tr><td>{{ $loop->index + 1 }}</td><td>{{ $element->site_name }}</td>
                <td><a href="{{ $element->site_uri }}" target="_blank" >{{ $element->site_uri }}</a></td>
                <td>{{ $element->link_text }}</td>
                <td>{{ $element->coast }} руб.</td>
                <td id="amount" name="{{ $element->id }}">{{ $element->subscribs_amount }}</td>
                <td>
                    @if ($element->status == 'blocked')
                <div class="bg-danger rounded text-center text-white">bloked</div>
                @endif
                @if ($element->status == 'stopped')
                <div class="bg-warning rounded text-center text-white">stopped</div>
                @endif
                @if ($element->status == 'active')
                <div class="bg-success rounded text-center text-white">active</div>
                @endif
                </td>
                <td id="info_sub{{ $element->id }}">
                    @if (Auth::user()->status == 'authorized')
                    @if (in_array( $element->id ,$subscribers_my ))
                    подписан
                    <p><a href="my_subscribes">перейти к подпискам</a></p>
                    @else
                    не_подписан
                    @endif
                    @else
                    <div class="alert alert-danger">вы  не авторизованы!</div>
                    @endif
                </td>
                <td id="td_buttons">
                    @if (Auth::user()->status == 'authorized')
                    @if(!isset($donors_list_subscribes_by_offer_id[$element->id]))
                       <button @disabled($element->status !== 'active') type="button " name_3="{{ $element->id }}" name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-success"data-bs-toggle="modal" data-bs-target="#offer_to_suscribe{{ $element->id }}" >подписаться</button>
                       <p id="full" name="{{ $element->id }}"><b></b></p>
                       @endif
                    @isset($donors_list_subscribes_by_offer_id[$element->id])

                    @if ($donors_list_subscribes_by_offer_id[$element->id] == count($donors))
                        <button disabled type="button " name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-success"data-bs-toggle="modal" data-bs-target="#offer_to_suscribe{{ $element->id }}" >подписаться</button>
                        <p><b>подписаны все ресурсы</b></p>
                    @else
                        <button @disabled($element->status !== 'active') type="button " name_3="{{ $element->id }}" name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-success"data-bs-toggle="modal" data-bs-target="#offer_to_suscribe{{ $element->id }}" >подписаться</button>
                    @endif
                    @endisset

                        <!-- The Modal -->
                      <div class="modal" id="offer_to_suscribe{{ $element->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">

                              <h4 class="modal-title">подписаться</h4>

                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form name="{{ $element->id }}" id="form_control" method="GET" action="offer_subscribe" onsubmit="event.preventDefault()" >
                             @csrf
                                <!-- Modal body -->
                            <div class="modal-body">
                                @if (!empty($donors))
                                <h5>Выберете ресурс для подписки и размещения ссылки</h4>
                                <input hidden type="text" name="offer_uri_id" value = "{{ $element->id }}">
                                <input hidden type="text" name="offer_uri" value = "{{ $element->site_uri }}">
                                <input hidden type="text" name="offer_coast" value = "{{ $element->coast }}">
                                <select id="select_offer" name_2="{{ $element->id }}" name="select_offer" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected disabled>-- Выберите ресурс --URL --</option>
                                    @foreach ($donors as $elemen)
                                    @if ($elemen->status == 'approved')
                                    @if (!in_array( $element->id , explode(",", $elemen->offer_reference) ))
                                    <option id="option" name="{{ $element->id }}" name_2="{{ $elemen->id }}" value="{{ $elemen->id }}">{{ $elemen->uri }}</option>
                                    @else
                                    <option id="option" name="{{ $element->id }}" name_2="{{ $elemen->id }}"  disabled value="{{ $elemen->id }}">
                                    <b>ресурс уже подписан:  </b>{{ $elemen->uri }}</option>
                                    @endif
                                    @else
                                    <option disabled value="{{ $elemen->id }}">
                                        <b>ресурс заблокирован: </b>{{ $elemen->uri }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">

                                <button offer_uri_id="{{ $element->id }}" offer_uri="{{ $element->site_uri }}" offer_coast="{{ $element->coast }}" @disabled($element->status !== 'active') onsubmit="event.preventDefault()" type="submit" name_2="{{ $element->id }}" name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-success" data-bs-dismiss="modal">подписаться</button>
                            </div>
                            @else
                            <h5>Для подписки внесите данные о своих web-ресурсах на странице <a href="my_resources">Мои_ресурсы</a></h5>
                                @endif
                            </form>
                          </div>
                        </div>
                      </div>

                        <noscript>
                        <h4 class="modal-title">Подписаться</h4>
                        <input hidden type="text" name="offer_uri" value = "{{ $element->site_uri }}">
                        <input hidden type="text" name="offer_coast" value = "{{ $element->coast }}">
                        <button @disabled($element->status !== 'active') type="submit" name="offer_id" value="{{ $element->id }}" id="{{ $element->id }}" class="btn btn-success">подписаться</button>
                        </noscript>
                    @else
                    <div class="alert alert-danger">запросите авторизацию</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        <script>const csrf = '{{ csrf_token() }}';</script>
        <script src="custom_scripts\webmaster_alloffers.js"></script>
</div>

    @endif




  


</div>



@else
<div class="alert alert-danger">вы  не авторизованы! Запросите авторизацию</div>
@endif


@endsection










