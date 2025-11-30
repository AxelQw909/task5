<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование заявления') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Информация о текущем статусе -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-800">
                                    <span class="font-medium">Текущий статус:</span> 
                                    @if($report->status->id === 1)
                                        <span class="text-yellow-600">На рассмотрении</span>
                                    @elseif($report->status->id === 2)
                                        <span class="text-green-600">Решено</span>
                                    @else
                                        <span class="text-red-600">Отклонено</span>
                                    @endif
                                </p>
                                <p class="text-xs text-blue-600 mt-1">
                                    Заявление №{{ $report->id }} создано {{\Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y')}}
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Поле для номера машины -->
                            <div>
                                <x-input-label for="number" :value="__('Госномер автомобиля')" />
                                <x-text-input 
                                    id="number" 
                                    name="number" 
                                    type="text" 
                                    class="block mt-1 w-full" 
                                    :value="old('number', $report->number)" 
                                    required 
                                    autofocus 
                                    placeholder="А123БВ777"
                                />
                                <x-input-error :messages="$errors->get('number')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">
                                    Введите госномер в формате: А123БВ777
                                </p>
                            </div>

                            <!-- Поле для описания -->
                            <div>
                                <x-input-label for="description" :value="__('Описание нарушения')" />
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="6"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Опишите подробно нарушение, которое вы заметили..."
                                    required
                                >{{ old('description', $report->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">
                                    Опишите место, время и детали нарушения
                                </p>
                            </div>

                            <!-- Кнопки -->
                            <div class="flex items-center justify-between pt-6">
                                <div class="flex space-x-3">
                                    <a href="{{ route('reports.show', $report->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Отмена
                                    </a>
                                    
                                    <a href="{{ route('reports.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-100 border border-transparent rounded-md font-semibold text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                        К списку заявлений
                                    </a>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <x-primary-button type="submit">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                        </svg>
                                        {{ __('Сохранить изменения') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Предупреждение о статусе -->
            @if($report->status->id != 1)
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Внимание</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Это заявление уже имеет статус "{{ $report->status->name }}".</p>
                            <p class="mt-1">Изменение информации может потребовать повторной проверки администратором.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>