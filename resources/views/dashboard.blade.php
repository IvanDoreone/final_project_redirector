@extends('layout')
@section('title') Личный кабинет @endsection
@section('main content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Личный кабинет') }}

        </h2>


    </x-slot>
    @auth
        
    <section>
        <div class="alert alert-info">
            <b><a class="me-3 py-2 link-body-emphasis" href="profile">Управление профилем</a></b>
        </div>
    <div class="alert alert-info">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            {{ __("Вы зарегистрированны!") }}
            <ul>
                <li>
                    Имя пользователя:  {{ Auth::user()->name }}
                </li>
                <li>
                    Ваша роль в системе: {{ Auth::user()->role }}               
                <li>
                    Ваш id: {{ Auth::user()->id }}
                </li>
            </ul>
            
        </div>

        @endauth
    </section>

    <article>
        <div class="alert alert-info">
            @if (Auth::user()->role === 'admin' )
            <ul>
                <li>
                   Управление пользователями (отзыв и предоставление авторизации) на странице:
                   <p><a class="me-3 py-2 link-body-emphasis" href="users_admin">Авторизация_Пользователей</a></p>
                </li>
                <li>
                    Управление офферами (блокировка и разрешение) на странице:
                    <p><a class="me-3 py-2 link-body-emphasis" href="offers_admin">Управление_Офферами</a></p>
                 </li>
                 <li>
                    Управление ресурсами вэбмастеров, зарегистрированными в системе на странице:
                    <p><a class="me-3 py-2 link-body-emphasis" href="resources_admin">Управление_Ресурсами</a></p>
                 </li>
                 <li>
                    Аналитика по переходам, отказам и доходу системы на странице:
                    <p><a class="me-3 py-2 link-body-emphasis" href="analitics_admin">Аналитика_Admin</a></p>
                 </li>
            </ul>    
            @endif
            @if (Auth::user()->role === 'client')
            <p>
                <h4>Правила работы в системе</h4>
                <ul>
                    <li>
                        Hа странице <a class="me-3 py-2 link-body-emphasis" href="offers">Мои_Оферы</a> у вас есть возможность зарегистрировать свой оффер, который будет доступен для просмотра
                        всем вэбмастерам, зарегисрированным в системе и доспупен для подписки на него.
                    </li>
                    <h5>Важно!</h5>
                    <li> 
                        При регистрации нового оффера укажите полный URL адрес вашей страницвы для перехода (начиная с https://), 
                        для того что бы система смогла сформировать прапвильную ссылку для размещения на ресурсе вэбмастера при подписке.
                    </li>
                    <li>
                        Укажите стоимость  - сколько вы готовы заплатить за один переход на страницу вашего оффера. 
                        Стоимость должна быть в пределах от 1 до 100 руб. за переход.
                    </li>
                    <li>
                        Каждый URL должен быть уникальным - т.е. 1 оффер = 1 уникальный URL.
                    </li>
                    <li>
                        Деактивировать свой оффер (закрыть его от просмотра вэбмастеров или отменить переходы по уже зарегистрированным нап
                        нем подпискам) вы можете в любой момент на этой же странице, как и удалить оффер (будьте внимательны, в этом случе оффер
                        будет удален навсегда, и в следующий раз вам придется регистрировать его заново)
                    </li>
                    <h5>Аналитика</h5>
                    <li>
                        Посмотреть кол-во подписок на ваши офферы, кол-во переходов и расходы по каждому офферу в разрезе день/месяц/год
                        вы можете прямо на странице <a class="me-3 py-2 link-body-emphasis" href="offers">Мои_Оферы</a> и более подробно на странице
                <a class="me-3 py-2 link-body-emphasis" href="analitics_client">персональной аналитики</a>.
                    </li>
                </ul>  
            @endif
            @if (Auth::user()->role === 'web_master')
            <p>
                <h4>Правила работы в системе</h4>
                <ul>
                    <li>
                        Hа странице <a class="me-3 py-2 link-body-emphasis" href="my_resources">Мои_ресурсы</a> у вас есть возможность зарегистрировать свой ресурс, 
                        что бы получить возможность подписаться на любой подходящий оффер.
                    </li>
                    <h5>Важно!</h5>
                    <li>
                        При добавлении ресурса система проверит, что URL вашего ресурса уникален (соблюдается правило 1 ресурс = 1 URL)!
                    </li>
                    <li>
                        Управлять своими подписками, и т.ч. остановить, возобновить или удалить подписку на всегда вы можете на 
                        странице управления подписками: <a class="me-3 py-2 link-body-emphasis" href="my_subscribes">Мои_подписки</a>
                    </li>
                    <li> 
                        Система берет комиссию в размере 20% от стоимости за переход, указанной в оффере на который вы оформляете подписку
                    </li>
                    <li>
                        Вы так же можете деактиваровать или удалить совй ресурс в любой момент на странице <a class="me-3 py-2 link-body-emphasis" href="my_resources">Мои_ресурсы</a>
                    </li>
                    <h5>Аналитика</h5>
                    <li>
                        Посмотреть кол-во подписок по своим ресурсам, кол-во переходов и доходы в целом и по каждой подписке в разрезе день/месяц/год
                        вы можете прямо на странице управления подписками  <a class="me-3 py-2 link-body-emphasis" href="my_subscribes">Мои_подписки</a> и более подробно на странице
                        <a class="me-3 py-2 link-body-emphasis" href="analitics_webmaster">персональной аналитики</a>.
                    </li>
                </ul>  
            @endif

        </div>
    </article>

    
    

@endsection
