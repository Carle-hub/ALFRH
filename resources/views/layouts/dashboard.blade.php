<!DOCTYPE html>
<html lang="fr" x-data="dashboard()" :class="{'dark': darkMode}" x-init="document.documentElement.classList.toggle('dark', darkMode)">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALFRH - Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireStyles
</head>
<body class="flex h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <!-- Sidebar -->
    <aside class="flex flex-col bg-white dark:bg-gray-800 shadow-lg transition-all duration-300"
           :class="collapsed ? 'w-20' : 'w-60'">
        <!-- Logo & Toggle -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <!-- Logo AF -->
                <img x-show="!collapsed" src="{{ asset('images.png') }}" alt="Logo AF" class="w-10 h-10">                
                <span x-show="!collapsed" class="ml-2 text-2xl font-bold text-blue-600">ALFRH</span>
            </div>
            <button @click="collapsed = !collapsed" class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': collapsed}" class="w-6 h-6 text-gray-600 dark:text-gray-300 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                </svg>
            </button>
        </div>
            <button @click="collapsed = !collapsed" class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': collapsed}" class="w-6 h-6 text-gray-600 dark:text-gray-300 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                </svg>
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 mt-4">
            <ul>
                <li class="mb-1">
                    <a href="#" class="group flex items-center p-3 rounded-lg mx-2 hover:bg-blue-100 dark:hover:bg-gray-700 transition-colors"
                       :class="{'bg-blue-50 dark:bg-gray-700': active === 'conge'}" @click.prevent="active = 'conge'">
                        <svg class="w-6 h-6 text-blue-600 group-hover:text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span x-show="!collapsed" class="ml-3 text-gray-700 dark:text-gray-200">Congés</span>
                        <span x-show="collapsed" class="sr-only">Congés</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="#" class="group flex items-center p-3 rounded-lg mx-2 hover:bg-blue-100 dark:hover:bg-gray-700 transition-colors"
                       :class="{'bg-blue-50 dark:bg-gray-700': active === 'retard'}" @click.prevent="active = 'retard'">
                        <svg class="w-6 h-6 text-yellow-500 group-hover:text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                        <span x-show="!collapsed" class="ml-3 text-gray-700 dark:text-gray-200">Retards</span>
                        <span x-show="collapsed" class="sr-only">Retards</span>
                    </a>
                </li>
                <li class="mb-1">
                    <a href="#" class="group flex items-center p-3 rounded-lg mx-2 hover:bg-blue-100 dark:hover:bg-gray-700 transition-colors"
                       :class="{'bg-blue-50 dark:bg-gray-700': active === 'absence'}" @click.prevent="active = 'absence'">
                        <svg class="w-6 h-6 text-red-500 group-hover:text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span x-show="!collapsed" class="ml-3 text-gray-700 dark:text-gray-200">Absences</span>
                        <span x-show="collapsed" class="sr-only">Absences</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Pied de page -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <button @click="toggleDarkMode()" class="w-full flex items-center justify-center py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <svg x-show="!darkMode" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-12.34l-.7.7M5.34 18.66l-.7.7M21 12h-1M4 12H3m16.66 5.66l-.7-.7M5.34 5.34l-.7-.7" />
                </svg>
                <svg x-show="darkMode" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3C11.4477 3 10.9218 3.09821 10.4456 3.28169C13.1282 5.41539 14.5 8.63527 14.5 12C14.5 15.3647 13.1282 18.5846 10.4456 20.7183C10.9218 20.9018 11.4477 21 12 21C17 21 21 17 21 12C21 7 17 3 12 3Z" />
                </svg>
                <span x-show="!collapsed" x-text="darkMode ? 'Mode clair' : 'Mode sombre'" class="ml-2"></span>
            </button>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Top navbar -->
        <header class="flex items-center justify-between bg-white dark:bg-gray-800 px-6 py-4 shadow-md">
            <div>
                <h2 class="text-2xl font-semibold">Tableau de bord</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span>Bonjour, <strong>{{ Auth::user()->name }}</strong></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Déconnexion</button>
                </form>
            </div>
        </header>

        <!-- Content area -->
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>
    </div>

    @livewireScripts
    <script>
    function dashboard() {
        return {
            collapsed: false,
            // Mode clair par défaut si aucune préférence enregistrée
            darkMode: localStorage.darkMode ? JSON.parse(localStorage.darkMode) : false,
            active: 'conge',
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.documentElement.classList.toggle('dark', this.darkMode);
                localStorage.darkMode = JSON.stringify(this.darkMode);
            }
        }
    }
    </script>
</body>
</html>
