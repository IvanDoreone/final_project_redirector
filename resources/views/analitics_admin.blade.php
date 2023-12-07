@extends('layout')
@section('title') Аналитика для Admin @endsection
@section('main content')
<h2>Аналитика по подпискам, переходам и доходам</h2>
<div class="alert alert-success">
    @if(!empty($subscribes))

<table class="table  table-striped" id="table_all">
    <tr>
        <th>Сводные данные</th><th> </th><th> </th><th> </th><th> </th><th> </th><th> </th><th>Переходы</th><th>Доход</th><th>Отказы</th>
    </tr>
        <tr>
            <th>Итого</th><th></th><th></th><th></th><th></th><th></th><th></th>
            <th>
                <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_amount">{{ $transition_amount_all }}</a>
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
                                           {{ $transition_amount_day }}
                                        </td>
                                        <td>
                                            {{ $transition_amount_month }}
                                        </td>
                                        <td>
                                            {{ $transition_amount_year }}
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
            <th>
                <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_profit">{{  $profit_all }} руб.</a>
                <!-- The Modal -->
                    <div class="modal" id="myModal_transitions_profit">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content overflow-auto">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Доходы день \ месяц \ год</h4>
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
                                           {{ $profit_day }}
                                        </td>
                                        <td>
                                            {{ $profit_month }}
                                        </td>
                                        <td>
                                            {{ $profit_year }}
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
            <th>
                <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_declines">{{  $declines_amount_all }}</a>
                <!-- The Modal -->
                    <div class="modal" id="myModal_transitions_declines">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content overflow-auto">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Отказы день \ месяц \ год</h4>
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
                                           {{ $declines_amount_day }}
                                        </td>
                                        <td>
                                            {{ $declines_amount_month }}
                                        </td>
                                        <td>
                                            {{ $declines_amount_year }}
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
        <caption>* - перенаправления на оффер по чужой или удаленной подписке</caption>
        <thead>

            <tr>
                <th>пп</th><th>id</th><th>Дата создания</th><th>Статус  подписки</th><th>Оффер</th><th>Ресурс</th><th>Цена перехода</th>
                <th data-field="subcriptops" data-sortable="true">Всего переходов</th><th>Доход системы</th><th>Кол-во отказов*</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>

            @foreach ($subscribes as $element)


            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $element->id }}</td>
                <td>{{ substr($element->created_at, 0,-9) }}</td>
                <td>
                    @if ($element->status == 'active')
                    <div class="bg-success rounded text-center text-white">active</div>
                    @else
                    <div class="bg-danger rounded text-center text-white">deleted</div>
                    @endif
                </td>
                <td>
                    {{ $element->offer_site_name }}
                    <p>offer id: <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_offer_id_{{ $element->offer_id }}">{{ $element->offer_id }}</a></p>

<!-- The Modal -->
<div class="modal" id="myModal_offer_id_{{ $element->offer_id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content overflow-auto">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Оффер ID {{ $element->offer_id }}</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            {{ $element->offer_uri }}
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
        </div>

      </div>
    </div>
  </div>

    <noscript>
        {{ $element->offer_uri }}
    </noscript>
                </td>
                <td>
                    {{ $element->donor_site_name }}
                    <p>donor id: <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_donor_id_{{ $element->donor_id }}">{{ $element->donor_id }}</a></p>

                    <!-- The Modal -->
                    <div class="modal" id="myModal_donor_id_{{ $element->donor_id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content overflow-auto">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">donor ID {{ $element->donor_id }}</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                {{ $element->donor_uri }}
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                            </div>

                          </div>
                        </div>
                      </div>

                        <noscript>
                            {{ $element->donor_uri }}
                        </noscript>
                </td>
                <td>{{ $element->coast }} руб.</td>
                <td>
                    @if ($element->transitions_count > 0)
                    <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_transitions_{{ $element->id }}">{{ $element->transitions_count }}</a>
                <!-- The Modal -->
                    <div class="modal" id="myModal_transitions_{{ $element->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content overflow-auto">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Переходы по этой ссылке (подписке)</h4>
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
                                            @foreach ($subscribes_day as $day )
                                            @if ($day->id == $element->id)
                                                {{ $day->transitions_count }}
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>
                                            @foreach ($subscribes_month as $month )
                                            @if ($month->id == $element->id)
                                                {{ $month->transitions_count }}
                                            @endif
                                        @endforeach
                                        </td>
                                        <td>
                                            @foreach ($subscribes_year as $year )
                                            @if ($year->id == $element->id)
                                                {{ $year->transitions_count }}
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
                      @else
                          {{ $element->transitions_count }}
                      @endif
                </td>
                <td>
                    @if ($element->transitions_count * $element->coast * 2/10 > 0)
                    <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_coasts_{{ $element->id }}">{{ $element->transitions_count * $element->coast * 2/10}} руб.</a>
                    <!-- The Modal -->
                        <div class="modal" id="myModal_coasts_{{ $element->id }}">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content overflow-auto">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Доход системы по этой ссылке (подписке)</h4>
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
                                                @foreach ($subscribes_day as $day )
                                                @if ($day->id == $element->id)
                                                    {{ $day->transitions_count * $element->coast * 2/10 }} руб.
                                                @endif
                                            @endforeach
                                            </td>
                                            <td>
                                                @foreach ($subscribes_month as $month )
                                                @if ($month->id == $element->id)
                                                    {{ $month->transitions_count * $element->coast * 2/10 }} руб.
                                                @endif
                                            @endforeach
                                            </td>
                                            <td>
                                                @foreach ($subscribes_year as $year )
                                                @if ($year->id == $element->id)
                                                    {{ $year->transitions_count * $element->coast * 2/10 }} руб.
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
                          @else
                        {{ $element->transitions_count * $element->coast * 2/10 }}
                          @endif
                </td>
                <td>
                    @if ($element->declanes_count > 0)
                    <a disabled href="#" data-bs-toggle="modal" data-bs-target="#myModal_list_declines{{ $element->id }}">{{ $element->declanes_count}}</a>
                    <!-- The Modal -->
                        <div class="modal" id="myModal_list_declines{{ $element->id }}">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content overflow-auto">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Отказы системы по этой ссылке (подписке)</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">

                                    <table class="table">
                                        <thead>
                                        <tr><th scope="col">ID Donor</th><th scope="col"></th><th scope="col">Кол-во отказов</th>
                                        </thead>
                                        <tr>
                                            <td>
                                                @foreach ($declines_list as $decline )
                                                @if ($decline->subscribes_id == $element->id)
                                                    {{ $decline->donor_id }}
                                                @endif
                                            @endforeach
                                            </td>
                                            <td>
                                                @foreach ($declines_list as $decline )
                                                @if ($decline->subscribes_id == $element->id)
                                                    {{ $decline->count }}
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
                          @else
                          {{ $element->declanes_count }}
                          @endif
                </td>
            </tr>
            @endforeach
        </table>

        <script src="custom_scripts\analitics_admin.js"></script>

        </div>

    @endif


</div>

@endsection
