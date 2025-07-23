<aside class="flex flex-col glass-effect border-r border-white/20 dark:border-gray-700/20 shadow-2xl transition-all duration-300"
       :class="collapsed ? 'w-20' : 'w-72'">
    <!-- Logo & bouton de réduction du menu -->
    <div class="flex items-center justify-between p-6 border-b border-white/20 dark:border-gray-700/20">
        <div class="flex items-center space-x-3" x-show="!collapsed">
            <div class="w-12 h-12">
                <img src="{{ asset('images.png') }}" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-red-500 to-indigo-600 bg-clip-text text-transparent">ALFRH</h1>
                <p class="text-xs text-gray-800 dark:text-gray-500">Alliance Française</p>
            </div>
        </div>
        <button @click="collapsed = !collapsed" 
                class="p-2.5 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 group">
            <svg :class="{'rotate-180': collapsed}" 
                 class="w-5 h-5 text-gray-600 dark:text-gray-300 transition-transform duration-300 group-hover:scale-110">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>
    <!-- Menu principal de navigation -->
    <nav class="flex-1 mt-4 px-4">
        <ul class="space-y-2">
            <li>
                <a href="#" @click.prevent="active = 'dashboard'" 
                   :class="{'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg': active === 'dashboard'}"
                   class="group flex items-center p-4 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 text-blue-500 group-hover:text-blue-600" :class="{'text-white': active === 'dashboard'}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="9"/>
                        <rect x="14" y="3" width="7" height="5"/>
                        <rect x="14" y="12" width="7" height="9"/>
                        <rect x="3" y="16" width="7" height="5"/>
                    </svg>
                    <span x-show="!collapsed" class="ml-4 font-medium">Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="#" @click.prevent="active = 'employe'" 
                   :class="{'bg-gradient-to-r from-emerald-500 to-green-500 text-white shadow-lg': active === 'employe'}"
                   class="group flex items-center p-4 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 text-emerald-500 group-hover:text-green-600" :class="{'text-white': active === 'employe'}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span x-show="!collapsed" class="ml-4 font-medium">Employés</span>
                </a>
            </li>
            <li>
                <a href="#" @click.prevent="active = 'conge'" 
                   :class="{'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg': active === 'conge'}"
                   class="group flex items-center p-4 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 text-blue-500 group-hover:text-blue-600" :class="{'text-white': active === 'conge'}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <span x-show="!collapsed" class="ml-4 font-medium">Congés</span>
                    <span x-show="!collapsed && active === 'conge'" class="ml-auto bg-white/30 text-xs px-2 py-1 rounded-full">24</span>
                </a>
            </li>
             <li>
                <a href="#" @click.prevent="active = 'absence'" 
                   :class="{'bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg': active === 'absence'}"
                   class="group flex items-center p-4 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 text-red-500 group-hover:text-red-600" :class="{'text-white': active === 'absence'}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="17" y1="17" x2="21" y2="21"/>
                        <line x1="21" y1="17" x2="17" y2="21"/>
                    </svg>
                    <span x-show="!collapsed" class="ml-4 font-medium">Absences</span>
                    <span x-show="!collapsed && active === 'absence'" class="ml-auto bg-white/30 text-xs px-2 py-1 rounded-full">12</span>
                </a>
            </li>
            <li>
                <a href="#" @click.prevent="active = 'retard'" 
                   :class="{'bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg': active === 'retard'}"
                   class="group flex items-center p-4 rounded-xl hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 text-yellow-500 group-hover:text-yellow-600" :class="{'text-white': active === 'retard'}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    <span x-show="!collapsed" class="ml-4 font-medium">Retards</span>
                    <span x-show="!collapsed && active === 'retard'" class="ml-auto bg-white/30 text-xs px-2 py-1 rounded-full">8</span>
                </a>
            </li>
      
        </ul>
        <div x-show="!collapsed" class="mt-8 pt-6 border-t border-white/20 dark:border-gray-700/20">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 font-semibold mb-3">Outils</h3>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="group flex items-center p-3 rounded-lg hover:bg-white/30 dark:hover:bg-gray-700/30 transition-colors">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="ml-3 text-sm">Rapports</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="group flex items-center p-3 rounded-lg hover:bg-white/30 dark:hover:bg-gray-700/30 transition-colors">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="ml-3 text-sm">Paramètres</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
            