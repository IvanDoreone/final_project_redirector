@extends('layout')
@section('title') Мои Подписки @endsection
@section('main content')
@if (Auth::user()->status == 'authorized' && Auth::user()->role == 'web_master')

<h2>Мои подписки</h2>

    @if(!empty($my_subscripts))

    <div class="alert alert-info overflow-auto">

        <table class="table table-striped" id="table"
        data-search="true"
        data-show-columns="true"
        data-show-multi-sort="true"
        data-sort-priority='[{"sortName": "date","sortOrder":"desc"},{"sortName":"subcriptops","sortOrder":"desc"}]'
        data-url="json/data3.json">
        <thead>
            <tr>
                <th>пп</th><th>Дата</th><th>Сайт</th><th>url клиента/мой ресурс</th><th>Статус подписки</th><th>Стоимость перехода</th><th>Переходы</th><th>Доход всего</th><th>Сылка на размещение</th><th>Управлять подпиской</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
        <tbody>
            @foreach ($my_subscripts as $element)

            
            <tr  id="tr_row_tr" name="{{ $element->id }}">
                <td id="tr_row" name="{{ $element->id }}">{{ $loop->index + 1 }}</td>
                <td id="tr_row" name="{{ $element->id }}">{{ substr($element->created_at, 0,-9) }}</td>
                <td id="tr_row" name="{{ $element->id }}">{{ $element->site_name }}</td>
                <td id="tr_row" name="{{ $element->id }}">
                    <a href="{{ $element->site_uri }}" target="_blank" >{{ $element->site_uri }}</a>
                    /<br>
                    <a href="{{ $element->donor_uri }}" target="_blank" >{{ $element->donor_uri }}</a>
                </td>
                <td id="tr_row" name="{{ $element->id }}">
                    @if ($element->status == 'active')
                    <div id="div_info" name="{{ $element->id }}" class="bg-success rounded text-center text-white">{{ $element->status }}</div>
                    @else
                    <div class="bg-warning rounded text-center">{{ $element->status }}</div>
                    @endif
                </td>
                <td id="tr_row" name="{{ $element->id }}">{{ $element->coast }} руб.</td>
                <td id="tr_row" name="{{ $element->id }}">
                    @foreach ($my_transitions as $transition)
                        @if ($transition->id == $element->id)
                            {{ $transition->count }}
                        @endif
                    @endforeach



                </td>
                <td id="tr_row" name="{{ $element->id }}">
                    @foreach ($my_transitions as $transition)
                        @if ($transition->id == $element->id)
                            <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions{{ $element->id }}">{{ $transition->count * $element->coast*8/10 }}</a>
                        @endif
                    @endforeach


                    <!-- The Modal -->
                    <div class="modal" id="myModal_transitions{{ $element->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content overflow-auto">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <b><h4 class="modal-title">доход по этой подписке</h4></b>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">

                                <table class="table">
                                    <thead>
                                    <tr><th scope="col">сегодня: {{ date('d.m') }}</th><th scope="col">месяц: {{ date('m.Y') }}</th><th scope="col">год:{{ date('Y') }}</th></tr>
                                    </thead>
                                    <tr>
                                        <td>
                                        @foreach ($my_transitionsday as $transitionday)
                                        @if ($transitionday->id == $element->id)
                                        {{ $transitionday->count * $element->coast*8/10}}
                                        @endif
                                        @endforeach
                                        </td>
                                        <td>
                                         @foreach ($my_transitionsmonth as $transitionmonth)
                                         @if ($transitionmonth->id == $element->id)
                                        {{ $transitionmonth->count * $element->coast*8/10}}
                                        @endif
                                        @endforeach
                                        </td>
                                        <td>
                                        @foreach ($my_transitionsyear as $transitionyear)
                                        @if ($transitionyear->id == $element->id)
                                        {{ $transitionyear->count * $element->coast*8/10}}
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
                            @foreach ($my_transitions as $transition)
                            @if ($transition->id == $element->id)
                                {{ $transition->count * $element->coast*8/10 }}
                            @endif
                        @endforeach
                        <table class="table">
                            <thead>
                            <tr><th scope="col">сегодня: {{ date('d.m') }}</th><th scope="col">месяц: {{ date('m.Y') }}</th><th scope="col">год:{{ date('Y') }}</th></tr>
                            </thead>
                            <tr>
                                <td>
                                @foreach ($my_transitionsday as $transitionday)
                                @if ($transitionday->id == $element->id)
                                {{ $transitionday->count * $element->coast*8/10}}
                                @endif
                                @endforeach
                                </td>
                                <td>
                                 @foreach ($my_transitionsmonth as $transitionmonth)
                                 @if ($transitionmonth->id == $element->id)
                                {{ $transitionmonth->count * $element->coast*8/10}}
                                @endif
                                @endforeach
                                </td>
                                <td>
                                @foreach ($my_transitionsyear as $transitionyear)
                                @if ($transitionyear->id == $element->id)
                                {{ $transitionyear->count * $element->coast*8/10}}
                                @endif
                                @endforeach
                                </td>
                            </tr>
                        </table>
                        </noscript>

                </td>
                <td id="tr_row" name="{{ $element->id }}">
                    <a style="pointer-events: none" href="http://localhost/redirector/laravel/public/redirector?link={{ $element->id }}">{{ $element->text }}</a>
                    <input style="width:0px; opacity: 0%" type="text" link = '<a href="http://localhost/redirector/laravel/public/redirector?link={{ $element->id }}">{{ $element->text }}</a>'  name="{{ $element->id }}" id="copy{{ $element->id }}" value='<a href="http://localhost/redirector/laravel/public/redirector?link={{ $element->id }}">{{ $element->text }}</a>'>
                    <p><button id="select" name="{{ $element->id }}" class="btn btn-info">скопировать</button></p>

                    <button hidden  data-bs-toggle="modal" data-bs-target="#myModal_copy{{ $element->id }}" type="button"  name="{{ $element->id }}" value="{{ $element->id }}" id="coppy_butt"></button>

                    <!-- The Modal -->
                <div class="modal" id="myModal_copy{{ $element->id }}">
                <div class="modal-dialog modal-sm">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">скопированно!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>ссылка:</p>
                        <p>http://localhost/redirector/laravel/public/redirector?link={{ $element->id }}</p>
                        <p>якорь:</p>
                        <p>{{ $element->text }}</p>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                    </div>

                </div>
                </div>
            </div>

                </td>
                <td id="tr_row" name="{{ $element->id }}">
                    <form id="form_control" name="{{ $element->id }}" method="GET" action="my_subscribes/control" onsubmit="event.preventDefault()">
                        @if ($element->status == 'active')
                        <p><button style="width: 110px; display: inline-block" type="submit"  name_2="{{ $element->id }}" name="to_stopped" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-warning rounded text-center">Остановить</button></p>
                        @endif
                        @if ($element->status == 'stopped')
                        <p><button style="width: 110px; display: inline-block" type="submit" name_2="{{ $element->id }}" name="to_active" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-success rounded text-center text-white">Возобновить</button></p>
                        @endif
                    </form>
                        <p><button data-bs-toggle="modal" data-bs-target="#myModal_delete{{ $element->id }}" style="width: 110px; display: inline-block" type="button" name_2="{{ $element->id }}" name="to_delete" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">Удалить</button></p>

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
                                    <form id="form_control2" name="{{ $element->id }}" method="Post" action="my_subscribes/delete" onsubmit="event.preventDefault()">
                                    @csrf
                                    <p><button data-bs-dismiss="modal" style="width: 110px; display: inline-block" type="submit" name_2="{{ $element->id }}" name="to_delete" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">Удалить</button></p>
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
            @endforeach
        </tbody>
        </table>
    </div>

<script>const csrf = '{{ csrf_token() }}';</script>
<script src="custom_scripts\webmaster_subscribes.js"></script>

@endif

@else
<div class="alert alert-danger">вы  не авторизованы! Запросите авторизацию</div>
@endif
@endsection
