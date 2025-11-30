<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Детали заявления') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Заголовок и статус -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Заявление №{{ $report->id }}</h1>
                            <p class="text-gray-500 mt-1">Госномер: {{ $report->number }}</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            @if($report->status->id === 1)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $report->status->name }}
                                </span>
                            @elseif($report->status->id === 2)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $report->status->name }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $report->status->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Информация о заявлении -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Основная информация</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Госномер автомобиля</dt>
                                    <dd class="text-sm text-gray-900 font-semibold">{{ $report->number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Дата создания</dt>
                                    <dd class="text-sm text-gray-900">{{\Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y H:i')}}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Последнее обновление</dt>
                                    <dd class="text-sm text-gray-900">{{\Carbon\Carbon::parse($report->updated_at)->translatedFormat('j F Y H:i')}}</dd>
                                </div>
                                @if(auth()->user()->is_admin && $report->user)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Автор заявления</dt>
                                    <dd class="text-sm text-gray-900">{{ $report->user->getFullNameAttribute() }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Статус заявления</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Текущий статус:</span>
                                    <span class="text-sm font-medium">
                                        @if($report->status->id === 1)
                                            <span class="text-yellow-600">На рассмотрении</span>
                                        @elseif($report->status->id === 2)
                                            <span class="text-green-600">Решено</span>
                                        @else
                                            <span class="text-red-600">Отклонено</span>
                                        @endif
                                    </span>
                                </div>
                                
                                @if(auth()->user()->is_admin)
                                <div class="pt-3 border-t border-gray-200">
                                    <form method="POST" action="{{ route('reports.status.update', $report) }}" class="status-form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center space-x-2">
                                            <select name="status_id" id="status_id" 
                                                    data-current-status="{{ $report->status->id }}"
                                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                @foreach($statuses ?? \App\Models\Status::all() as $statusItem)
                                                    <option value="{{ $statusItem->id }}" 
                                                            {{ $report->status->id == $statusItem->id ? 'selected' : '' }}>
                                                        {{ $statusItem->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-primary-button type="submit" class="whitespace-nowrap">
                                                Обновить
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Описание нарушения -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Описание нарушения</h3>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $report->description }}</p>
                        </div>
                    </div>

                    <!-- Действия -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-6 mt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="{{ route('reports.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Назад к списку
                            </a>
                            
                            @if(!auth()->user()->is_admin)
                            <a href="{{ route('reports.edit', $report) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Редактировать
                            </a>
                            @endif
                        </div>

                        @if(!auth()->user()->is_admin)
                        <div class="mt-4 sm:mt-0">
                            <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Вы уверены, что хотите удалить это заявление?')"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Удалить
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>