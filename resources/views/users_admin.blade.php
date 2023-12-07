@extends('layout')
@section('title') Управление пользователями @endsection
@section('main content')
<h2>Все пользователи - авторизация / отзыв</h2>

    @if(!empty($users))
    <div class="alert alert-info">

        <table class="table  table-striped" id="table"
        data-search="true"
        data-show-columns="true"
        data-show-multi-sort="true"
        data-sort-priority='[{"sortName": "date","sortOrder":"desc"},{"sortName":"subcriptops","sortOrder":"desc"}]'
        data-url="json/data3.json">
        <thead>
            <tr>
                <th>пп</th><th>Дата регистрации</th><th>Имя</th><th>email</th><th>Роль</th><th>Статус</th><th>Изменить статус</th>
            </tr> <!--ряд с ячейками заголовков-->
        </thead>
            @foreach ($users as $element)


            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ substr($element->created_at, 0,-9) }}</td>
                <td>{{ $element->name }}</td>
                <td>{{ $element->email }}</td>
                <td>{{ $element->role }}</td>
                <td>
                    @if ($element->status == 'authorized')
                    <div name="{{ $element->id }}" id="div_info" class="bg-success rounded text-center text-white">авторизован</div>
                    @else
                    <div name="{{ $element->id }}" id="div_info" class="bg-warning rounded text-center">не_авторизован</div>
                    @endif
                </td>
                <td>
                    <form onsubmit="event.preventDefault()" method="GET" action="users_control" id="form_control" name="{{ $element->id }}" onsubmit="event.preventDefault()">
                    @csrf
                    @if ($element->status == 'authorized')
                    <button type="submit" name="user_stop_authorize" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-danger rounded text-center text-white">отменить авторизацию</button>
                    @else
                    <button type="submit" name="user_start_authorize" value="{{ $element->id }}" id="{{ $element->id }}" class="bg-success rounded text-center text-white">предоставить авторизацию</button>
                    @endif
                    </form>


                </td>
            </tr>
            @endforeach
        </table>

@endif

</div>

<script>const csrf = '{{ csrf_token() }}';</script>
<script src="custom_scripts\admin_users.js"></script>

@endsection
