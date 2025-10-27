<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <a href="{{route ('reports.create')}}">Создать</a>
    
    <div>
        <span>Сортировка по дате создания: </span>
        <a href="{{ route('reports.index', ['sort' => 'desc', 'status'=>$status]) }}">Сначала новые</a>
        <a href="{{ route('reports.index', ['sort' => 'asc', 'status'=>$status]) }}">Сначала старые</a>
    </div>

    <div>
        <p>Фильтрация по статусу заявки</p>
            <ul>
                @foreach($statuses as $status)
                    <li>
                        <a href="{{route('reports.index', ['status' => $status->id])}}">
                            {{$status->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
    </div>

     @foreach ($reports as $report)
	 <div class="card">
                <tr>
                    <td><a href="{{route('reports.show',$report->id)}}">{{$report->number}}</a></td>
                    <td>{{ $report->description }}</td>
                    <td>{{ $report->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $report->status->name}}</td>
                </tr>

                
            <form method="POST" action="{{route('reports.destroy', $report->id)}}">
                @method('delete')
                @csrf
                <input type="submit" value="Удалить">
            </form>
            <a href="{{route('reports.edit',$report->id)}}">Изменить</a>
        </div>
    @endforeach
    
    {{ $reports->links() }}
</body>
</html>