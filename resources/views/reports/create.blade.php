<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Создание заявления') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Поле для номера машины -->
                            <div>
                                <x-input-label for="number" :value="__('Госномер автомобиля')" />
                                <x-text-input 
                                    id="number" 
                                    name="number" 
                                    type="text" 
                                    class="block mt-1 w-full" 
                                    :value="old('number')" 
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
                                >{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500">
                                    Опишите место, время и детали нарушения
                                </p>
                            </div>

                            <!-- Кнопки -->
                            <div class="flex items-center justify-between pt-6">
                                <a href="{{ route('reports.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Назад к списку
                                </a>
                                
                                <x-primary-button class="ml-3">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('Создать заявление') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Подсказка -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Полезная информация</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>• Указывайте точный госномер автомобиля</p>
                            <p>• Опишите нарушение максимально подробно</p>
                            <p>• Укажите место и время нарушения</p>
                            <p>• После создания заявления вы сможете отслеживать его статус</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>