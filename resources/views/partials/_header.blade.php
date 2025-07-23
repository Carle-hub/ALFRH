<header class="glass-effect border-b border-white/20 dark:border-gray-700/20 px-8 py-4 shadow-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                <span x-text="getPageTitle()"></span>
            </h2>
        </div>
        <div class="flex items-center space-x-4">
            <button @click="toggleDarkMode()" 
                    class="p-3 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 group">
                <svg x-show="!darkMode" class="w-5 h-5 text-yellow-500 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
                </svg>
                <svg x-show="darkMode" class="w-5 h-5 text-blue-400 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"/>
                </svg>
            </button>
            <div class="flex items-center space-x-3 bg-white/50 dark:bg-gray-800/50 px-4 py-2 rounded-xl">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-semibold text-white">
                        {{ strtoupper(Str::substr(Auth::user()->name, 0, 1)) }}{{ Str::substr(Str::after(Auth::user()->name, ' '), 0, 1) }}
                    </span>
                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-red-500/25 transform hover:scale-105">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</header>
