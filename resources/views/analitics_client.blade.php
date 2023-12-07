@extends('layout')
@section('title') Аналитика по моим размещенным офферам @endsection
@section('main content')
@if (Auth::user()->status == 'authorized')


<h3>Аналитика по офферам</h3>

    @if(!empty($offers))

    <div class="alert alert-info">
        <table class="table  table-striped" id="table_all">

            <tr>
                <th>Сводные данные</th><th>Переходы:</th>

                <th>
                    <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_count">{{ $expense}}</a>
                    <!-- The Modal -->
                        <div class="modal" id="myModal_transitions_count">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content overflow-auto">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Переходы день \ месяц \ год</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">

                                    <table class="table">
                                        <thead>
                                        <tr><th scope="col">сегодня: {{ date('d.m') }}</th><th scope="col">месяц: {{ date('m.Y') }}</th><th scope="col">год:{{ date('Y') }}</th>
                                        </thead>
                                        <tr>
                                            <td>
                                               {{ $expenseday}}
                                            </td>
                                            <td>
                                                {{ $expensemonth}}
                                            </td>
                                            <td>
                                                {{ $expenseyear}}
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
                </th>
                <th>Расход:</th>
                <th>
                    <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_amount">{{ $transition_all }}</a>
                    <!-- The Modal -->
                        <div class="modal" id="myModal_transitions_amount">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content overflow-auto">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Переходы день \ месяц \ год</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">

                                    <table class="table">
                                        <thead>
                                        <tr><th scope="col">сегодня: {{ date('d.m') }}</th><th scope="col">месяц: {{ date('m.Y') }}</th><th scope="col">год:{{ date('Y') }}</th>
                                        </thead>
                                        <tr>
                                            <td>
                                               {{ $transitions_day }}
                                            </td>
                                            <td>
                                                {{ $transitions_month }}
                                            </td>
                                            <td>
                                                {{ $transitions_year }}
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
                </th>
            </tr> <!--ряд с ячейками заголовков-->

    </table>







        <table class="table  table-striped" id="table"
        data-search="true"
        data-show-columns="true"
        data-show-multi-sort="true"
        data-sort-priority='[{"sortName": "date","sortOrder":"desc"},{"sortName":"subcriptops","sortOrder":"desc"}]'
        data-url="json/data3.json">
        <thead>
            <tr>
                <th>пп</th><th>Дата</th><th>Сайт</th><th>url</th><th>Якорь</th><th>Статус</th><th data-field="subcriptops" data-sortable="true">Подписчики</th><th>Кол-во Переходов</th><th>Расходы</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
            @foreach ($offers as $element)


            <tr><td>{{ $loop->index + 1 }}</td><td>{{ substr($element->created_at, 0,-9) }}</td><td>{{ $element->site_name }}</td>
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
                    <div class="bg-danger rounded text-center text-white">blocked by admin</div>
                    @endif
                    @if ($element->status == 'stopped')
                    <div class="bg-warning rounded text-center text-white">stopped by me</div>
                    @endif
                    @if ($element->status == 'active')
                    <div class="bg-success rounded text-center text-white">active</div>
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions{{ $element->id }}">{{ $transition->count_transitions }}</a>
                        @endif
                    @endforeach

                    <!-- The Modal -->
                <div class="modal" id="myModal_transitions{{ $element->id }}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Переходы по этому офферу</h4>
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
                                    {{ $transitionday->count_transitions}}
                                    @endif
                                    @endforeach
                                    </td>
                                    <td>
                                     @foreach ($transitionsmonth as $transitionmonth)
                                     @if ($transitionmonth->id == $element->id)
                                    {{ $transitionmonth->count_transitions}}
                                    @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach ($transitionsyear as $transitionyear)
                                    @if ($transitionyear->id == $element->id)
                                    {{ $transitionyear->count_transitions}}
                                    @endif
                                    @endforeach
                                    </td>
                                    <td>
                                        @foreach ($transitionsall as $transitionall)
                                        @if ($transitionall->id == $element->id)
                                        {{ $transitionall->count_transitions}}
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
                            {{ $transitionday->count_transitions}}
                            @endif
                            @endforeach
                            </td>
                            <td>
                             @foreach ($transitionsmonth as $transitionmonth)
                             @if ($transitionmonth->id == $element->id)
                            {{ $transitionmonth->count_transitions}}
                            @endif
                            @endforeach
                            </td>
                            <td>
                            @foreach ($transitionsyear as $transitionyear)
                            @if ($transitionyear->id == $element->id)
                            {{ $transitionyear->count_transitions}}
                            @endif
                            @endforeach
                            </td>
                            <td>
                                @foreach ($transitionsall as $transitionall)
                                @if ($transitionall->id == $element->id)
                                {{ $transitionall->count_transitions}}
                                @endif
                                @endforeach
                            </td>
                        </tr>
                    </table>
                    </noscript>

                </td>
                <td>
                    @foreach ($transitions as $transition)
                        @if ($transition->id == $element->id)
                            <a href="#" data-bs-toggle="modal" data-bs-target="#myModal_expense{{ $element->id }}">{{ $transition->summ }} руб.</a>
                        @endif
                    @endforeach

                    <!-- The Modal -->
                <div class="modal" id="myModal_expense{{ $element->id }}">
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

            </tr> <!--ряд с ячейками тела таблицы-->

            @endforeach

        </table>
        <script src="custom_scripts\client_analitics.js"></script>

        </div>

    @endif

</div>


@else
<div class="alert alert-danger">вы  не авторизованы! Запросите авторизацию</div>
@endif






@endsection
