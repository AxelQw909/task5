@props(['sort', 'status', 'statuses'])

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