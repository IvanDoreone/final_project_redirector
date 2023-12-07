<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class = "bg-dark text-white">

<div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom bg-dark text-decoration-none">
<div class="container">
</div>
    <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
    @auth
        <a href="{{ url('/dashboard') }}" class="me-3 py-2 link-body-emphasis text-white" href="reviewers">личный кабинет</a>
    @else
        <a href="{{ route('login') }}" class="me-3 py-2 link-body-emphasis text-white">войти</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="me-3 py-2 link-body-emphasis text-white">зарегистироваться</a>
        @endif
    @endauth
    </nav>
</div>
{{ getcwd() }}
<div class="alert alert-info">
    <p><b>Добро пожаловать в Редиректор!</b></p>
    Система размещения, регистрации и учета трафика рекламных переходов с ресурсов вэбмастеров на страницы рекламодателей
    <p><b>Рекламодателю</b></p>
    Зарегистрируйтесь или войдите с ролью "Client" - вы сможете зарегистрировать свои страницы (офферы) на которые подпишуться вэбмастера
    и обеспечат трафик клиентов на вашу страницу
    <p><b>Вэбмастеру</b></p>
    Зарегистрируйтесь или войдите с ролью "Web Master" - вы получите доступ ко всем оферам в системе и возможность оформить подписку.
</div>

    <main class="d-flex flex-nowrap">
        <div class="container">
            @yield('main content')
        </div>
      </main>

















    <x-footer-component></x-footer-component>

</body>
</html>
