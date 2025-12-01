<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-bold">Редактирование заявления #{{ $report->id }}</h1>
            <p class="text-gray-600 mt-1">Госномер: {{ $report->number }}</p>
        </div>

        <form action="{{ route('reports.update', $report->id) }}" method="POST" class="bg-white p-6 rounded-lg border space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Госномер автомобиля *</label>
                <input type="text" name="number" value="{{ old('number', $report->number) }}" required 
                       class="w-full px-3 py-2 border rounded-lg">
                @error('number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Описание нарушения *</label>
                <textarea name="description" rows="4" required
                          class="w-full px-3 py-2 border rounded-lg">{{ old('description', $report->description) }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('reports.show', $report->id) }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Отмена
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</x-app-layout>