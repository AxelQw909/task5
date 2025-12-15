@props(['status'])

@php
    // Определяем текст и цвет в зависимости от статуса
    $config = [
        1 => ['text' => 'Новое', 'bg' => 'bg-blue-100', 'textColor' => 'text-blue-800'],
        2 => ['text' => 'В работе', 'bg' => 'bg-yellow-100', 'textColor' => 'text-yellow-800'],
        3 => ['text' => 'Выполнено', 'bg' => 'bg-green-100', 'textColor' => 'text-green-800'],
    ];
    
    $configItem = $config[$status] ?? ['text' => 'Неизвестно', 'bg' => 'bg-gray-100', 'textColor' => 'text-gray-800'];
@endphp

<span class="px-3 py-1 rounded-full text-sm font-medium {{ $configItem['bg'] }} {{ $configItem['textColor'] }}">
    {{ $configItem['text'] }}
</span>