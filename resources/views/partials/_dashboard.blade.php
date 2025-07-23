<div x-show="active === 'dashboard'" class="animate-fade-in">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Cartes statistiques -->
        <div class="glass-effect p-6 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Employés</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalEmployes }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="glass-effect p-6 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Congé</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalConges }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="glass-effect p-6 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Retards</p>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $totalRetards }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="glass-effect p-6 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Absences</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $totalAbsences }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- Graphiques et activités récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 glass-effect p-6 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20">
            <h3 class="text-lg font-semibold mb-4">Activité de la semaine</h3>
            <div class="h-64 flex items-center justify-center text-gray-500">
            </div>
        </div>
        <div class="glass-effect p-6 rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20">
            <h3 class="text-lg font-semibold mb-4">Activités récentes</h3>
        </div>
    </div>
</div>
