@extends('layout')
@section('title') Тестовая страница для размещения ссылок @endsection
@section('main content')
<div class="container alert alert-info">
<h3>Тестовые ссылки</h3>



<p>подписанная:</p>
<a href="http://localhost/redirector/laravel/public/redirector?link=64">normal text now</a>
<p>подписанная:</p>
<a href="http://localhost/redirector/laravel/public/redirector?link=65">продажа всего и всем!!!</a>
<p>не 
    подписанная:</p>
<a href="http://localhost/redirector/laravel/public/redirector?link=61">удаленная подписка</a>


@endsection

