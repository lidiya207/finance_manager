<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Finance Manager') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div id="app" class="flex flex-col h-screen overflow-hidden">
        @auth
        <!-- Top Navbar -->
        <nav class="bg-white shadow-md border-b border-red-200 h-16 flex items-center justify-between px-6">
            <a href="{{ route('dashboard') }}" class="text-3xl font-extrabold tracking-widest text-red-800 hover:text-red-600 transition-colors">
                <span class="text-4xl">💰</span> Finance Manager
            </a>
            <div class="flex items-center">
                <span class="font-medium text-red-800 mr-12">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-white font-medium px-1 py-2 transition-colors duration-200 hover:opacity-90" style="background-color:hsl(221, 92.00%, 43.90%); border-radius: 8px;" type="submit">Logout</button>
                </form>
            </div>
        </nav>

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-50 border-r border-gray-200">
                <div class="flex flex-col h-full">
                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 overflow-y-auto">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 px-3">Finance</h3>
                        
                        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('income.index') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('income.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Income
                        </a>
                        
                        <a href="{{ route('expenses.index') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('expenses.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            Expenses
                        </a>
                        
                        <a href="{{ route('loans.index') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('loans.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Loans
                        </a>
                        
                        <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Reports
                        </a>
                        
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 mt-6 px-3">Settings</h3>
                        
                        <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </a>
                        
                        <a href="{{ route('repayments.index') }}" class="flex items-center px-3 py-2.5 mb-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('repayments.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Repayments
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden min-w-0">
                <main class="flex-1 overflow-y-auto bg-gray-50 min-w-0 pt-20">
                    @yield('content')
                </main>
                
                <!-- Footer -->
                <footer class="flex-shrink-0 min-w-0 text-gray-400 py-3 px-4 border-t border-gray-800" style="background-color: #000000 !important; width: 100%;">
                    <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-2">
                        <div class="flex flex-col sm:flex-row items-center gap-3 text-sm">
                            <span>© {{ date('Y') }} Finance Manager</span>
                            <div class="flex items-center gap-3">
                                <a href="#" class="hover:text-gray-300 transition-colors">Terms</a>
                                <a href="#" class="hover:text-gray-300 transition-colors">Privacy</a>
                                <a href="#" class="hover:text-gray-300 transition-colors">Cookies</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @else
        <!-- Content for unauthenticated users (login/register pages) -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
            
          <!-- Footer -->
<footer class="w-full text-gray-400 py-3 px-6 border-t border-gray-800 bg-black">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-2 max-w-screen-xl mx-auto">
        <div class="flex flex-col sm:flex-row items-center gap-3 text-sm">
            <span>© {{ date('Y') }} Finance Manager</span>
            <div class="flex items-center gap-3">
                <a href="#" class="hover:text-gray-300 transition-colors">Terms</a>
                <a href="#" class="hover:text-gray-300 transition-colors">Privacy</a>
                <a href="#" class="hover:text-gray-300 transition-colors">Cookies</a>
            </div>
        </div>
    </div>
</footer>

        </div>
        @endauth
    </div>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
