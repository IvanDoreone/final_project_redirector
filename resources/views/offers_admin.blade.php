@extends('layout')
@section('title') Все офферы системы - управление @endsection
@section('main content')
<h2>Все Офферы - просмотр / блокировка</h2>
@if(!empty($offers))
<div class="alert alert-info">

    <table class="table  table-striped" id="table"
    data-search="true"
    data-show-columns="true"
    data-show-multi-sort="true"
    data-sort-priority='[{"sortName": "date","sortOrder":"desc"},{"sortName":"subcriptops","sortOrder":"desc"}]'
    data-url="json/data3.json">
    <thead>
        <tr>
            <th>пп</th><th>Дата создания</th><th>сайт</th><th>url</th><th>якорь</th><th>цена перехода</th><th>Статус</th><th>Управлять</th>
        </tr> <!--ряд с ячейками заголовков-->
    </thead>
       @foreach ($offers as $element)




        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ substr($element->created_at, 0,-9) }}</td>
            <td>{{ $element->site_name }}</td>
            <td>{{ $element->site_uri }}</td>
            <td>{{ $element->link_text }}</td>
            <td>{{ $element->coast }}</td>
            <td>
                @if ($element->status == 'blocked')
                <div name="{{ $element->id }}" id="div_info" class="bg-danger rounded text-center text-white">bloked</div>
                @endif
                @if ($element->status == 'stopped')
                <div name="{{ $element->id }}" id="div_info" class="bg-warning rounded text-center">stopped</div>
                @endif
                @if ($element->status == 'active')
                <div name="{{ $element->id }}" id="div_info" class="bg-success rounded text-center text-white">active</div>
                @endif

            </td>
            <td>
                <form id="form_control" onsubmit="event.preventDefault()" method="GET" action="offers_control" name="{{ $element->id }}">
                @csrf
                @if ($element->status === 'blocked')
                <button type="submit" name="unblock" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-success rounded text-center text-white">разблокировать</button>
                @else
                <button type="submit" name="block" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">блокировать</button>
                @endif
                </form>


            </td>
        </tr>
    @endforeach
    </table>


<script>const csrf = '{{ csrf_token() }}';</script>
<script src="custom_scripts\offers_admin.js"></script>


@endif

</div>

@endsection
