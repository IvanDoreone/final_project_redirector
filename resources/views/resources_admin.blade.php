@extends('layout')
@section('title') Управление ресурсами @endsection
@section('main content')
<h2>Все ресурсы - просмотр / блокировка</h2>

    @if(!empty($resuorces))
    <div class="alert alert-info">

        <table class="table  table-striped" id="table"
        data-search="true"
        data-show-columns="true"
        data-show-multi-sort="true"
        data-sort-priority='[{"sortName": "date","sortOrder":"desc"},{"sortName":"subcriptops","sortOrder":"desc"}]'
        data-url="json/data3.json">
        <thead>
            <tr>
                <th>пп</th><th>Дата создания</th><th>сайт</th><th>url</th><th>тема</th><th>цена клика</th><th>Статус</th><th>Изменить статус</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
            @foreach ($resuorces as $element)


            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ substr($element->created_at, 0,-9) }}</td>
                <td>{{ $element->name }}</td>
                <td>{{ $element->uri }}</td>
                <td>{{ $element->theme }}</td>
                <td>{{ $element->coast }}</td>
                <td>
                    @if ($element->status == 'approved')
                    <div name="{{ $element->id }}" id="div_info" class="bg-success rounded text-center text-white">approved</div>
                    @else
                    <div name="{{ $element->id }}" id="div_info" class="bg-warning rounded text-center">not_approved</div>
                    @endif
                </td>
                <td>
                    <form id="form_control" onsubmit="event.preventDefault()" method="GET" action="resources_control" name="{{ $element->id }}">
                    @csrf
                    @if ($element->status == 'approved')
                    <button type="submit" name="resource_to_stop" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">блокировать</button>
                    @else
                    <button type="submit" name="resource_to_start" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-success rounded text-center text-white">разблокировать</button>
                    @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </table>


<script>const csrf = '{{ csrf_token() }}';</script>
<script src="custom_scripts\resources_admin.js"></script>


@endif












</div>
@endsection
