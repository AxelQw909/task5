<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-bold">Заявление #{{ $report->id }}</h1>
            <div class="flex items-center space-x-3 mt-2">
                <span class="font-medium">{{ $report->number }}</span>
                @if($report->status->id === 1)
                    <span class="text-sm bg-yellow-100 text-yellow-800 px-2 py-1 rounded">На рассмотрении</span>
                @elseif($report->status->id === 2)
                    <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">Решено</span>
                @else
                    <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded">Отклонено</span>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg border space-y-4">
            <div>
                <p class="text-sm text-gray-600">Дата создания</p>
                <p class="font-medium">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y H:i') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Описание нарушения</p>
                <p class="mt-1 whitespace-pre-wrap">{{ $report->description }}</p>
            </div>

            @if(auth()->user()->is_admin && $report->user)
            <div>
                <p class="text-sm text-gray-600">Автор</p>
                <p class="font-medium">{{ $report->user->getFullNameAttribute() }}</p>
            </div>
            @endif

            @if(auth()->user()->is_admin)
            <div class="pt-4 border-t">
                <form method="POST" action="{{ route('reports.status.update', $report) }}" class="flex items-center space-x-2">
                    @csrf
                    @method('PATCH')
                    <label class="text-sm font-medium text-gray-700">Статус:</label>
                    <select name="status_id" class="px-3 py-1 border rounded">
                        @foreach($statuses ?? \App\Models\Status::all() as $statusItem)
                            <option value="{{ $statusItem->id }}" {{ $report->status->id == $statusItem->id ? 'selected' : '' }}>
                                {{ $statusItem->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                        Обновить
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="flex justify-between">
            <a href="{{ route('reports.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                ← Назад к списку
            </a>
            
            <div class="flex space-x-2">
                @if(!auth()->user()->is_admin)
                <a href="{{ route('reports.edit', $report) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Редактировать
                </a>
                <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Удалить заявление?')" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Удалить
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>