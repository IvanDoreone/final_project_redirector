@extends('layout')
@section('title') Аналитика для Webmaster @endsection
@section('main content')
<h2>Аналитика по подпискам, переходам и доходам</h2>
@if (Auth::user()->status == 'authorized')

    @if(!empty($my_subscripts))

    <div class="alert alert-info overflow-auto">

        <table class="table  table-striped" id="table_all">

                <tr>
                    <th>Сводные данные</th><th>Переходы:</th>
                    <th>
                        <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_amount">{{ $transition }}</a>
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
                                                   {{ $transitionsday }}
                                                </td>
                                                <td>
                                                    {{ $transitionsmonth }}
                                                </td>
                                                <td>
                                                    {{ $transitionsyear }}
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
                    <th>Доход:</th>
                    <th>
                        <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_expense_amount">{{ $expense * 8/10 }}</a>
                        <!-- The Modal -->
                            <div class="modal" id="myModal_expense_amount">
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
                                                   {{ $expenseday * 8/10 }}
                                                </td>
                                                <td>
                                                    {{ $expensemonth * 8/10 }}
                                                </td>
                                                <td>
                                                    {{ $expenseyear * 8/10 }}
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
                <th>пп</th><th>Дата</th><th>оффер</th><th>мой ресурс</th><th>Статус подписки</th><th>Стоимость перехода</th><th>Переходы</th><th>Доход</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
            @foreach ($my_subscripts as $element)


            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ substr($element->created_at, 0,-9) }}</td>
                <td>
                    ID: <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_offers{{ $element->id }}">{{ $element->offer_id }}</a>



                <!-- The Modal -->
                <div class="modal" id="myModal_offers{{ $element->id }}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content overflow-auto">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <b><h4 class="modal-title">Данные по Offer ID: {{ $element->offer_id }}</h4></b>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                           <ul>
                            <li>
                                Site: {{ $element->site_name }}
                            </li>
                            <li>
                                URL: {{ $element->site_uri }}
                            </li>
                           </ul>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                        </div>

                      </div>
                    </div>
                  </div>

                    <noscript>
                        <ul>
                            <li>
                                Site: {{ $element->site_name }}
                            </li>
                            <li>
                                URL: {{ $element->site_uri }}
                            </li>
                           </ul>
                    </noscript>

                </td>
                <td>
                    ID: <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_resourse{{ $element->id }}">{{ $element->donor_id }}</a>

                    <!-- The Modal -->
                    <div class="modal" id="myModal_resourse{{ $element->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content overflow-auto">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <b><h4 class="modal-title">Данные по Donor ID: {{ $element->donor_id }}</h4></b>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">

                               <ul>
                                <li>
                                    Site: {{ $element->donor_name }}
                                </li>
                                <li>
                                    URL: {{ $element->donor_uri }}
                                </li>
                               </ul>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                            </div>

                          </div>
                        </div>
                      </div>

                        <noscript>
                            <ul>
                                <li>
                                    Site: {{ $element->site_name }}
                                </li>
                                <li>
                                    URL: {{ $element->site_uri }}
                                </li>
                               </ul>
                        </noscript>
                </td>
                <td>
                    @if ($element->status == 'active')
                    <div class="bg-success rounded text-center text-white">{{ $element->status }}</div>
                    @else
                    <div class="bg-warning rounded text-center">{{ $element->status }}</div>
                    @endif
                </td>
                <td>{{ $element->coast }} руб.</td>
                <td>
                    @foreach ($my_transitions as $transition)
                        @if ($transition->id == $element->id)
                            {{ $transition->count }}
                        @endif
                    @endforeach

                </td>
                <td>
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



            </tr>
            @endforeach
        </table>
    </div>

    <script src="custom_scripts\webmaster_analitics.js"></script>


@endif

@else
<div class="alert alert-danger">вы  не авторизованы! Запросите авторизацию</div>
@endif






@endsection
