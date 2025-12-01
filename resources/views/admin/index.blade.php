<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-bold">Панель администратора</h1>
            <p class="text-gray-600 mt-1">Управление заявлениями</p>
        </div>

        <!-- статистика -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg border">
                <p class="text-sm text-gray-600">Всего</p>
                <p class="text-2xl font-bold">{{ $reports->count() }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg border">
                <p class="text-sm text-gray-600">На рассмотрении</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $reports->where('status_id', 1)->count() }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg border">
                <p class="text-sm text-gray-600">Решено</p>
                <p class="text-2xl font-bold text-green-600">{{ $reports->where('status_id', 2)->count() }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg border">
                <p class="text-sm text-gray-600">Отклонено</p>
                <p class="text-2xl font-bold text-red-600">{{ $reports->where('status_id', 3)->count() }}</p>
            </div>
        </div>

        <!-- таблица -->
        <div class="bg-white rounded-lg border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Пользователь</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Госномер</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Дата</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Статус</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $report->id }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium">{{ $report->user->name }} {{ $report->user->lastname }}</div>
                                <div class="text-xs text-gray-500">{{ $report->user->email }}</div>
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $report->number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('reports.status.update', $report->id) }}" class="status-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_id" data-current-status="{{ $report->status_id }}" 
                                            class="text-sm border rounded px-2 py-1">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $status->id === $report->status_id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Просмотр
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($reports->isEmpty())
            <div class="p-8 text-center text-gray-500">
                Нет заявлений
            </div>
            @endif
        </div>
    </div>
</x-app-layout>