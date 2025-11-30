<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->is_admin)
                {{ __('Все заявления') }}
            @else
                {{ __('Мои заявления') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Фильтры и сортировка -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Сортировка -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Сортировка по дате</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('reports.index', ['sort' => 'desc', 'status' => $status]) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md {{ $sort === 'desc' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition duration-150">
                                    Сначала новые
                                </a>
                                <a href="{{ route('reports.index', ['sort' => 'asc', 'status' => $status]) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md {{ $sort === 'asc' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition duration-150">
                                    Сначала старые
                                </a>
                            </div>
                        </div>

                        <!-- Фильтрация по статусу -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Фильтр по статусу</h3>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('reports.index', ['sort' => $sort]) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md {{ !$status ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition duration-150">
                                    Все
                                </a>
                                @foreach($statuses as $statusItem)
                                    <a href="{{ route('reports.index', ['status' => $statusItem->id, 'sort' => $sort]) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md {{ $status == $statusItem->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition duration-150">
                                        {{ $statusItem->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Кнопка создания -->
            <div class="mb-6">
                <a href="{{ route('reports.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Создать заявление
                </a>
            </div>

            <!-- Список заявлений -->
            @if($reports->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Номер</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Описание</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата создания</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reports as $report)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                                {{ $report->number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $report->description }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($report->status->id === 1)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ $report->status->name }}
                                                </span>
                                            @elseif($report->status->id === 2)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $report->status->name }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $report->status->name }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    Просмотр
                                                </a>
                                                @if(!auth()->user()->is_admin)
                                                    <a href="{{ route('reports.edit', $report->id) }}" class="text-green-600 hover:text-green-900">
                                                        Изменить
                                                    </a>
                                                    <form method="POST" action="{{ route('reports.destroy', $report->id) }}" class="inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить это заявление?')" 
                                                                class="text-red-600 hover:text-red-900">
                                                            Удалить
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @else
                <!-- Сообщение об отсутствии заявлений -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Заявления отсутствуют</h3>
                        <p class="mt-1 text-gray-500">
                            @if(auth()->user()->is_admin)
                                В системе пока нет заявлений.
                            @else
                                У вас пока нет заявлений.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('reports.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Создать первое заявление
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>