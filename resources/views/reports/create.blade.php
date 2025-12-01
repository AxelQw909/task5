<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-bold">Создание заявления</h1>
            <p class="text-gray-600 mt-1">Заполните информацию о нарушении</p>
        </div>

        <form action="{{ route('reports.store') }}" method="POST" class="bg-white p-6 rounded-lg border space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Госномер автомобиля *</label>
                <input type="text" name="number" value="{{ old('number') }}" required 
                       class="w-full px-3 py-2 border rounded-lg" placeholder="А123БВ777">
                @error('number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Описание нарушения *</label>
                <textarea name="description" rows="4" required
                          class="w-full px-3 py-2 border rounded-lg" 
                          placeholder="Опишите нарушение...">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('reports.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Отмена
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Создать заявление
                </button>
            </div>
        </form>
    </div>
</x-app-layout>