@extends('layout')
@section('title') Main page @endsection
@section('main content')


        <div class="container">
            <h3>Edit the new</h3>


      @php
      //var_dump($data);
      @endphp




      <div class="container">
        <form method="POST" action="/laravel3/laravel/public/news/{{ $data[0]['id'] }}">
            @csrf
            @method('PUT')
        <textarea type="text" name="thenew" id="thenew" class="form-control" value="{{ $data[0]['thenew'] }}">{{ $data[0]['thenew'] }}</textarea><br>
        <button type="submit" name="news_id" value="{{ $data[0]['id'] }}" id="{{ $data[0]['id'] }}" class="btn btn-warning">Edit</button>
        </form>
      </div>



        </div>
      </main>

@endsection


























