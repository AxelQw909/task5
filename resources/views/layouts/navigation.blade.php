<nav class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route(auth()->user()->is_admin ? 'admin.index' : 'dashboard') }}" class="text-lg font-bold">
                    НарушенийНет
                </a>
                
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.*') ? 'text-blue-600 font-medium' : 'text-gray-700' }}">
                        Панель администратора
                    </a>
                    <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'text-blue-600 font-medium' : 'text-gray-700' }}">
                        Все заявления
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-medium' : 'text-gray-700' }}">
                        Главная
                    </a>
                    <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'text-blue-600 font-medium' : 'text-gray-700' }}">
                        Мои заявления
                    </a>
                    <a href="{{ route('reports.create') }}" class="{{ request()->routeIs('reports.create') ? 'text-blue-600 font-medium' : 'text-gray-700' }}">
                        Подать заявление
                    </a>
                @endif
            </div>

            
            <div class="flex items-center">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100">
                        
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        
                    </button>

                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Профиль
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                Выйти
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>