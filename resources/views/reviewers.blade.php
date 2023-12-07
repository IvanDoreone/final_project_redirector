@extends('layout')
@section('title') Main page @endsection
@section('main content')
<h2>Список тех кто пишет нам отзывы</h2>
<div class="alert alert-success">
    <p>Здесь будет список email тех кто написал отзыв и дата их первой публикации на сайтe</p>
    <table class="table  table-striped">
        <?php
        $i = 1;
        $arr = [];
        ?>
        <tr><th>id</th><th>email</th><th>время публикации</th></tr> <!--ряд с ячейками заголовков-->

 @if (!empty($reviewers))
    @foreach ($reviewers as $reviewer)

        @if (!in_array($reviewer->email, $arr))
        <tr><td><?php echo ($i++) ?></td><td>{{$reviewer->email }}</td><td>{{$reviewer->created_at }}</td>  </tr> <!--ряд с ячейками тела таблицы-->
        @endif
    <?php
    array_push($arr, $reviewer->email);
    ?>
    @endforeach





@endif
    </table>
</div>






@endsection
