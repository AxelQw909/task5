<x-app-layout>
    <div class="space-y-6">
        <!-- Заголовок -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                @if(auth()->user()->is_admin)
                    Панель администратора
                @else
                    Добро пожаловать, {{ Auth::user()->name }}!
                @endif
            </h1>
            <p class="text-gray-600 mt-1">
                @if(auth()->user()->is_admin)
                    Управление всеми заявлениями
                @else
                    Система для подачи заявлений о нарушениях
                @endif
            </p>
        </div>

        <!-- Для администратора -->
        @if(auth()->user()->is_admin)
            <!-- Статистика -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">Всего заявлений</p>
                    <p class="text-2xl font-bold">{{ $totalReports ?? 0 }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">На рассмотрении</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingReports ?? 0 }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">Решено</p>
                    <p class="text-2xl font-bold text-green-600">{{ $resolvedReports ?? 0 }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border">
                    <p class="text-sm text-gray-600">Отклонено</p>
                    <p class="text-2xl font-bold text-red-600">{{ $rejectedReports ?? 0 }}</p>
                </div>
            </div>

            <!-- Действия -->
            <div class="bg-white p-6 rounded-lg border">
                <h2 class="text-lg font-semibold mb-4">Быстрые действия</h2>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Все заявления
                    </a>
                    <a href="{{ route('reports.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Создать заявление
                    </a>
                </div>
            </div>
        @else
            <!-- Для обычного пользователя -->
            <div class="bg-white p-6 rounded-lg border">
                <h2 class="text-lg font-semibold mb-4">Мои заявления</h2>
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-600">Всего: <span class="font-bold">{{ $userReportsCount ?? 0 }}</span></p>
                            <p class="text-gray-600">На рассмотрении: <span class="font-bold text-yellow-600">{{ $userPendingReports ?? 0 }}</span></p>
                            <p class="text-gray-600">Решено: <span class="font-bold text-green-600">{{ $userResolvedReports ?? 0 }}</span></p>
                        </div>
                        <a href="{{ route('reports.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Подать заявление
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Последние заявления -->
        <div class="bg-white rounded-lg border overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">
                    @if(auth()->user()->is_admin)
                        Последние заявления
                    @else
                        Мои последние заявления
                    @endif
                </h2>
            </div>
            
            @if(isset($recentReports) && $recentReports->count() > 0)
                <div class="divide-y">
                    @foreach($recentReports as $report)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium">№{{ $report->id }} - {{ $report->number }}</span>
                                        @if($report->status->id === 1)
                                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">На рассмотрении</span>
                                        @elseif($report->status->id === 2)
                                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Решено</span>
                                        @else
                                            <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Отклонено</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('j F Y H:i') }}</p>
                                </div>
                                <a href="{{ route('reports.show', $report) }}" class="text-blue-600 hover:text-blue-800">
                                    Подробнее →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="p-4 border-t">
                    <a href="{{ route('reports.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Смотреть все →
                    </a>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>Нет заявлений</p>
                    <a href="{{ route('reports.create') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                        Создать первое заявление
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>