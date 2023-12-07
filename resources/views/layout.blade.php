<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="custom_css\styles.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js"></script>

<!-- Bootsrap & JS plugin for sorting tables!-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<!-- Bootsrap & JS plugin for sorting tables end!-->

</head>
<body class = "bg-dark text-white">
<div class="container-fluid">
<div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom bg-dark text-decoration-none">
    
    @auth
    <span class="fs-5 text-white link-body-emphasis allign-center" >Добро пожаловать, {{ Auth::user()->name }} !</span>
    <div class='position-absolute top-0 end-0'>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button id="exit" type="submit" class="me-5 py-1 w-80 btn btn-lg btn-warning ">exit</button>
    </form>
    </div>
    @endauth

    </div>
    
      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">

            @auth
                <a href="{{ url('/dashboard') }}" class="me-3 py-2 link-body-emphasis text-white" href="reviewers">Личный_кабинет</a>
            @else
                <a href="{{ route('login') }}" class="me-3 py-2 link-body-emphasis text-white">Войти</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="me-3 py-2 link-body-emphasis text-white">Зарегистироваться</a>
                @endif
            @endauth
        {{-- <a class="me-3 py-2 link-body-emphasis text-white" href="tests">tests</a> --}}
        <a class="me-3 py-2 link-body-emphasis text-white" href="news">Тестовые_ссылки</a>
        @if (Auth::user()->role === 'client')
        <a class="me-3 py-2 link-body-emphasis text-white" href="offers">Мои_Оферы</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="analitics_client">Аналитика_Client</a>
        @endif
        @if (Auth::user()->role === 'web_master')
        <a class="me-3 py-2 link-body-emphasis text-white" href="my_resources">Мои_ресурсы</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="all_offers">Все_офферы</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="my_subscribes">Мои_подписки</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="analitics_webmaster">Аналитика_WebMastr</a>
        @endif
        @if (Auth::user()->role === 'admin')
        <a class="me-3 py-2 link-body-emphasis text-white" href="analitics_admin">Аналитика_Admin</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="offers_admin">Управление_Офферами</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="resources_admin">Управление_Ресурсами</a>
        <a class="me-3 py-2 link-body-emphasis text-white" href="users_admin">Авторизация_Пользователей</a>
        @endif
                
      </nav>
    
    <main class="d-flex flex-nowrap">
        <div class="container">
            @yield('main content')
        </div>
      </main>

    </div>

    <x-footer-component></x-footer-component>
    
</body>
</html>
