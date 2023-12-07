<table>
    <tr>
        <th>id</th><th>автор</th><th>заголовок</th><th>delete</th><th>edit</th></tr> <!--ряд с ячейками заголовков-->

    @foreach ((session()->all())['neeew'] as $new)


    <tr><td>{{ $loop->index }}</td><td>{{ $new['name'] }}</td><td><a href="news/{{ $loop->index }}">{{ $new['title'] }}</a></td>
        <td>
            <form method="POST" action="news/{{ $loop->index }}">
                @csrf
                @method('DELETE')

                <button type="submit" name="news_id" value="{{ $loop->index }}" id="{{ $loop->index }}" >Delete</button>
            </form>
        </td>
    </tr> <!--ряд с ячейками тела таблицы-->


    @endforeach


</table>
