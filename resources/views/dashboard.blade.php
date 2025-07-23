<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALFRH - Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'slide-in': 'slideIn 0.3s ease-out',
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'bounce-subtle': 'bounceSubtle 0.6s ease-out',
                    }
                }
            }
        }
    </script>
    <style>
        /* Animations personnalisées pour les transitions */
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounceSubtle {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
            60% { transform: translateY(-3px); }
        }
        /* Effet de verre pour les cartes et la sidebar */
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        .dark .glass-effect {
            background: rgba(31, 41, 55, 0.9);
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body 
    x-data="dashboard()" 
    :class="{'dark': darkMode}" 
    class="flex h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 text-gray-800 dark:text-gray-100 transition-all duration-300"
>
    @include('partials._sidebar')
    <div class="flex-1 flex flex-col overflow-hidden">
        @include('partials._header')
        <main class="flex-1 p-8 overflow-auto">
            @include('partials._dashboard')
            @include('partials._employe')
            @include('partials._conge')
            @include('partials._solde_conge')
            @include('partials._absence')
            @include('partials._retard')
            {{-- menu solde conge tsy tokony eto e--}}
        </main>
    </div>
    @livewireScripts
    <script>
    // Fonction Alpine.js pour gérer l'état du dashboard
    function dashboard() {
        return {
            collapsed: false,
            darkMode: localStorage.darkMode ? JSON.parse(localStorage.darkMode) : false,
            active: 'dashboard',
            employeSearch: '',
            employeSort: 'nom',
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.documentElement.classList.toggle('dark', this.darkMode);
                localStorage.darkMode = JSON.stringify(this.darkMode);
            },
            getPageTitle() {
                switch(this.active) {
                    case 'dashboard': return 'Tableau de bord';
                    case 'conge': return 'Gestion des Congés';
                    case 'retard': return 'Gestion des Retards';
                    case 'absence': return 'Gestion des Absences';
                    case 'solde_conge': return 'Solde des Congés'; // Ajout
                    default: return '';
                }
            }
        }
    }

    // La gestion des employés est désormais dynamique via AJAX dans _employe.blade.php
    </script>
</body>
</html>