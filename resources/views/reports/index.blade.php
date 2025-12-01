<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold">
                    @if(auth()->user()->is_admin)
                        Все заявления
                    @else
                        Мои заявления
                    @endif
                </h1>
                <p class="text-gray-600 mt-1">
                    @if(auth()->user()->is_admin)
                        Управление всеми заявлениями
                    @else
                        История ваших заявлений
                    @endif
                </p>
            </div>
            <a href="{{ route('reports.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Создать
            </a>
        </div>

        <!-- фильтры -->
        <div class="bg-white p-4 rounded-lg border">
            <div class="flex flex-wrap gap-4">
                <div>
                    <p class="text-sm font-medium mb-2">Сортировка:</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('reports.index', ['sort' => 'desc', 'status' => $status]) }}" 
                           class="px-3 py-1 text-sm border rounded {{ $sort === 'desc' ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' }}">
                            Сначала новые
                        </a>
                        <a href="{{ route('reports.index', ['sort' => 'asc', 'status' => $status]) }}" 
                           class="px-3 py-1 text-sm border rounded {{ $sort === 'asc' ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' }}">
                            Сначала старые
                        </a>
                    </div>
                </div>
                
                <div>
                    <p class="text-sm font-medium mb-2">Статус:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('reports.index', ['sort' => $sort]) }}" 
                           class="px-3 py-1 text-sm border rounded {{ !$status ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' }}">
                            Все
                        </a>
                        @foreach($statuses as $statusItem)
                            <a href="{{ route('reports.index', ['status' => $statusItem->id, 'sort' => $sort]) }}" 
                               class="px-3 py-1 text-sm border rounded {{ $status == $statusItem->id ? 'bg-blue-600 text-white' : 'hover:bg-gray-50' }}">
                                {{ $statusItem->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- список -->
        <div class="bg-white rounded-lg border divide-y">
            @if($reports->count() > 0)
                @foreach($reports as $report)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('reports.show', $report->id) }}" class="font-medium hover:text-blue-600">
                                    {{ $report->number }}
                                </a>
                                @if($report->status->id === 1)
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">На рассмотрении</span>
                                @elseif($report->status->id === 2)
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Решено</span>
                                @else
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Отклонено</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $report->description }}</p>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y H:i') }}
                            </p>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Просмотр
                            </a>
                            @if(!auth()->user()->is_admin)
                            <a href="{{ route('reports.edit', $report->id) }}" class="text-green-600 hover:text-green-800 text-sm">
                                Изменить
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- пагинация -->
                <div class="p-4">
                    {{ $reports->links() }}
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>Заявления не найдены</p>
                    <a href="{{ route('reports.create') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                        Создать первое заявление
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>