### Финальный проект/ SF-AdTech (Система Редиректор) Группа 35
### Иван Дорофеев
---
# ВАЖНО!
Для корректого запуска приложения после команды ***git clone*** в выбранную вами дирректорию
замените в файле ***routes\web.php*** код на строке 50 (корневой маршрут):
```
50| Route::get('redirector_test/final_project_redirector2/public/', function () {
```
имя корневой дирректории ***redirector_test*** на ***имя_своей_дирректории*** в которую вы склонировали проект
 или замените на
```
50| Route::get('/', function () {
```
и после этого обязательная команда
***php artisan route:clear***
для полной очистки кэша маршрутов

### Описание:
### Система Редиректор для создания и учета рекламных переходов с ресурсов Вэбмастеров на ресурсы Клиентов

### Функционал системы для пользователей:
В системе есть 3 роли для пользователей **(Client, Web Master, Admin)**, для выбора свой роли пользователю необходимо выбрать ее из списка при регистрации.
Выбор роли Admin заблокирован, **тестовый акаунт для Admin: admin@admin.ru / 12345678**
+ **Рекламодатель (Client)**  
    - подробная инструкция находится в разделе "Личный Кабинет".
    - Может добавлять информацию о своих ресурсах (на которые хочет получить трафик с ресурсов Вэбмастеров)
При регистрации ресурса Client указывает имя сайта, полный URL страницы, текст ссылки (якорь) для размещения на ресурсе вэбмастера,
тему сайта и стоимость - сколько готов платить за переход в рублях от 1 до 100. **URL должен быть уникальным для каждого оффера.**
    - В разделе "Мои офферы" Client может отредактировать свой оффер, удалить его или деактивировать что бы тот не был виден вэбмастерам в системе и не доступен для подписок.
    - Так же имеет возможность посмотреть на кол-во подписок на свои офферы, их текущий статус и кол-во переходов на свои ресурсы по
оформленным подпискам и расходы по отдельным офферам и в целом в разрезе день/месяц/год  в разделе Мои Офферы и более подробно в 
разделе Аналитика Client.
    - Управление свой учетной записью, а как же удаление акаунта происходит в разделе Личный кабинет/Управление проффилем.
+ **Webmaster** 
    - Подробная инструкция находится в разделе "Личный Кабинет".
    - Может добавлять информацию о своих ресурсах (этими ресурсами он будет оформять подписку на офферы)
При регистрации ресурса Webmaster указывает имя сайта, полный URL страницы,
тему сайта и желаемую стоимость перехода. **URL должен быть уникальным для каждого ресурса.**
    - В разделе "Мои ресурсы" Webmaster может отредактировать свой оффер или  удалить его если еще не оформил ни одной подписки на нем.
    - В разделе "Все офферы" Webmaster видит все офферы в системе и может оформить подписку любым из свои ресурсов.
**На каждый конкретный оффер Webmaster может подписать только один из своих ресурсов**
    - В разделе "Мои подписки" Webmaster может управлять ими: останавливать и запускать, а так же удалять подписки, просмартивать  кол-во 
подписок оформленных на каждом ресурсе и кол-во переходов по подпискам и доходы от них в разрезе день/месяц/год.
Так же в этом разделе Webmaster может скопировать ссылку для размещения на своем ресурсе по оформленной подписке (**Система автоматически формирует эту ссылку при оформлении новой подписки с якорем клиента**).
    - Более подробно посмотреть информацию о переходах и доходах Webmaster может в разделе "Аналитика Webmaster".
Система Редиректор берет фиксированную комиссию (20%) от стоимости каждого перехода в подписке.
    - Управление свой учетной записью, а как же удаление аакаунта происходит в разделе Личный кабинет/Управление проффилем.
+ **Admin**
    - Управляет авторизацией пользователей, допуском к размещению офферов и ресурсов на соотвествующих страницач при входе в систему 
под своей учетной записью (**тестовый акаунт для Admin: admin@admin.ru / 12345678**).
    - В разделе "Аналитика" Admin может подробно ознакомиться с информацией о доходе системы (от комиссии) в целом и по каждому офферу,
оценить кол-во переходов и отказов системы (когда происходит попытка перехода с ресурса вэбмастера на оффер, на который он не подписан).
Все данные представленны в разрезе день/месяц/год : для этого надо кликнуть на общее кол-во переходов или доход, дополнительная
информация будет предоставлена в модальном окне.

### Особенности реализации
+ Проект сделан на основе Laravel 10
+ Система аутентификации и регистрации на пакете Breese
+ База данных MySQL (Maria DB):
    - БД выгружена в файл: ***laravel.sql***
    - имя БД: Laravel
        - DB_USERNAME=root2
        - DB_PASSWORD=root
        - структура (не дефолтная для Laravel):
            - users (данные пользователей и их роли и статус)
            - offers (данные офферов, их стаус)
            - donors (данные ресурсов вэбмастеров и их статус)
            - subscribes (оформленные подписки и их статус, при удалении подписки информация о ней сохраняется в БД, но статус переводится в deleted)
            - transitions (переходы)
            - declanes (отказы)
    - В таблицах проставлены индексы: для ускорения поиска при запросах по необходимым столбцам и ограничения внешних ключей.
    - Все изменения в ДБ сделаны с помощью последовательных миграций.
+ Все переходы как удачные, так и не удачные и отказы записываются в логи:
    - все переходы: ***\storage\logs\redirect.log***
    - удачные: ***\storage\logs\success_transitions.log***
    - отказы: ***\storage\logs\declines.log***
+ В разделе "Тестовые ссылки" есть возможность протестировать переход, размести ссылку с рарегистривонной подписки на ресурс (страница): ***news***
- шаблон: ***resources\views\news.blade.php***
+ Все взаимодействие пользователей с системой осуществляется без перезагрузки страниц, включая отправку форм,
редактирование ресурсов и оформление подписки на основе AJAX (XMLHTTPrequest) на чистом JS.
+ Сортировка, пагинация и поиск в таблицах реализованы на Bootstrap 5 (DataTable).
+ Офрмление страниц и форм Bootstrap 5.
+ Кастомные стили в папке ***public/custom_css***
+ Кастомный скрипт JS в папке ***public\custom_scripts***
+ Все контроллеры (кроме регистрации и аутентификации) в папке ***app/Http/Controllers***
+ Тонкий контролер (помошники для формирования страниц и запросов к БД) реализован в папке ***app\Actions***
+ В шаблоны страниц добавлена миркоразметка.

 
#### Файл с базой данных для проекта (testtable) в файле ***laravel.sql***


---
### Использованные технологии:
+ Laravel 10 c пакетом Breese
+ PHP 8.2
+ JS 
+ HTML5
+ CSS
+ boostrap 5.0
+ Jquery для сортировки таблиц




---
Иван Дорофеев &copy; 2023
License: [MIT](https://mit-license.org/)
