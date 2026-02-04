<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Finance Manager')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-slate-900 font-sans antialiased transition-colors duration-200">
    <div id="app" class="flex flex-col h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        @auth
        <!-- Top Navbar -->
        <nav class="bg-white dark:bg-slate-800 shadow-md border-b border-red-200 dark:border-slate-700 h-16 flex items-center justify-between px-4 md:px-6 transition-colors duration-200 z-40 relative">
            <div class="flex items-center gap-2 md:gap-4">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-extrabold tracking-widest text-red-800 dark:text-red-500 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                    <span class="text-2xl md:text-4xl">💰</span>
                    <span class="text-lg md:text-3xl">Finance Manager</span>
                </a>
            </div>
            <div class="flex items-center gap-2 md:gap-4">
                <span class="font-medium text-red-800 dark:text-gray-200 hidden md:block">{{ Auth::user()->name }}</span>
                <span class="font-medium text-red-800 dark:text-gray-200 text-sm md:hidden">{{ Str::limit(Auth::user()->name, 8) }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-white font-medium px-3 py-1.5 md:px-4 md:py-2 transition-colors duration-200 hover:opacity-90 text-xs md:text-base whitespace-nowrap" style="background-color:hsl(221, 92.00%, 43.90%); border-radius: 8px;" type="submit">Logout</button>
                </form>
            </div>
        </nav>

        <div class="flex flex-1 overflow-hidden relative">
            <!-- Mobile Backdrop -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
                 style="display: none;"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? '!translate-x-0' : ''" class="absolute inset-y-0 left-0 z-30 w-64 bg-gray-50 dark:bg-slate-900 border-r border-gray-200 dark:border-slate-700 transition-transform duration-300 transform -translate-x-full md:relative md:translate-x-0 ease-in-out">
                <div class="flex flex-col h-full">
                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 overflow-y-auto">
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 px-3">Finance</h3>
                        
                        <a href="{{ route('dashboard') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-slate-800 text-gray-900 dark:text-white' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('income.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('income.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Income
                        </a>
                        
                        <a href="{{ route('expenses.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('expenses.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            Expenses
                        </a>
                        
                        <a href="{{ route('loans.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('loans.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Loans
                        </a>
                        
                        <a href="{{ route('reports.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Reports
                        </a>
                        
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 mt-6 px-3">Settings</h3>
                        
                        <a href="{{ route('banks.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('banks.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            Banks
                        </a>

                        <a href="{{ route('categories.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </a>
                        
                        <a href="{{ route('repayments.index') }}" @click="if(window.innerWidth < 768) sidebarOpen = false" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('repayments.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Repayments
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden min-w-0" @click="if(window.innerWidth < 768) sidebarOpen = false">
                <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-slate-900 min-w-0 pt-6 px-4 md:px-0 transition-colors duration-200">
                    <div class="md:px-8">
                        @yield('content')
                    </div>
                </main>
                
                
            </div>
        </div>
        @else
        <!-- Content for unauthenticated users (login/register pages) -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
            
          <!-- Footer -->

        </div>
        @endauth
    </div>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
