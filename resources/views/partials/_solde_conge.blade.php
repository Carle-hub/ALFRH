<div x-show="active === 'solde_conge'" class="animate-fade-in" x-data="soldeCongePage()" x-init="fetchSoldeConges()">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <button
            class="px-4 py-2 bg-gradient-to-r from-blue-100 to-blue-300 text-blue-800 dark:from-blue-900 dark:to-blue-700 dark:text-blue-200 rounded-lg font-semibold shadow hover:from-blue-200 hover:to-blue-400 dark:hover:from-blue-800 dark:hover:to-blue-600 transition"
            @click="active = 'conge'"
            type="button"
        >
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Demandes de congés
        </button>
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Année :</label>
                <select x-model="selectedYear" class="px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm focus:ring-2 focus:ring-blue-400">
                    <option value="">Toutes</option>
                    <template x-for="year in years" :key="year">
                        <option :value="year" x-text="year"></option>
                    </template>
                    <option value="__edit__">Autre...</option>
                </select>
                <template x-if="selectedYear === '__edit__'">
                    <input
                        type="number"
                        min="2023"
                        max="2050"
                        x-model="customYear"
                        @change="
                            if(customYear && !years.includes(Number(customYear))) {
                                years.push(Number(customYear));
                                years.sort((a,b)=>b-a);
                            }
                            selectedYear = customYear;
                        "
                        placeholder="Entrer une année"
                        class="ml-2 px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm w-24 focus:ring-2 focus:ring-blue-400"
                    >
                </template>
            </div>
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-600 dark:text-gray-300 font-semibold">Employé :</label>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Rechercher un employé..."
                    class="px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm focus:ring-2 focus:ring-blue-400"
                >
            </div>
        </div>
    </div>
    <div class="glass-effect rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/20 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800">
            <h4 class="text-xl font-bold text-blue-800 dark:text-blue-200 tracking-wide flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M3 17v-2a4 4 0 014-4h10a4 4 0 014 4v2"/>
                </svg>
                Récapitulatif des soldes de congés pour l'annee suivante
            </h4>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider whitespace-nowrap">Employé</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider whitespace-nowrap">Année</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider whitespace-nowrap">Semestre 1</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider whitespace-nowrap">Semestre 2</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider whitespace-nowrap">Solde Annuel restant(S2)</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider whitespace-nowrap">Report/Déduction</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="row in paginatedSoldeConges()" :key="row.employe_id + '-' + row.annee">
                        <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/40 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white font-bold mr-2" x-text="row.nom ? row.nom.split(' ').map(x=>x[0]).join('').toUpperCase().slice(0,2) : '?'"></span>
                                <span x-text="row.nom"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" x-text="row.annee"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-block px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 font-semibold" x-text="row.semestre1"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-block px-2 py-1 rounded-full bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-200 font-semibold" x-text="row.semestre2"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full font-bold"
                                    :class="row.solde_restant > 0
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                                        : (row.solde_restant < 0
                                            ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'
                                            : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200')"
                                    x-text="row.solde_restant"
                                ></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-block px-2 py-1 rounded-full"
                                    :class="row.report_info.includes('Déduction') ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300'
                                        : row.report_info.includes('Report') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
                                        : row.report_info.includes('épuisé') ? 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-200'
                                        : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'"
                                    x-text="row.report_info"
                                ></span>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="paginatedSoldeConges().length === 0">
                        <td colspan="6" class="text-center py-6 text-gray-400">Aucune donnée disponible.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination controls -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 border-t border-gray-200 dark:border-gray-700" x-show="totalPages() > 1">
            <div class="text-sm text-gray-500 mb-2 md:mb-0" x-text="`Page ${currentPage} sur ${totalPages()}`"></div>
            <div class="flex flex-wrap gap-1">
                <button
                    class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
                    :disabled="currentPage === 1"
                    @click="currentPage--"
                >Précédent</button>
                <template x-for="page in totalPages()" :key="page">
                    <button
                        class="px-3 py-1 rounded-lg"
                        :class="currentPage === page ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-800'"
                        @click="currentPage = page"
                        x-text="page"
                    ></button>
                </template>
                <button
                    class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
                    :disabled="currentPage === totalPages()"
                    @click="currentPage++"
                >Suivant</button>
            </div>
        </div>
    </div>
</div>
<script>
function soldeCongePage() {
    return {
        soldeConges: [],
        years: [],
        selectedYear: '',
        customYear: '',
        search: '',
        currentPage: 1,
        perPage: 10,
        fetchSoldeConges() {
            fetch('/solde-conges')
                .then(r => r.json())
                .then(data => {
                    this.soldeConges = data;
                    this.years = [...new Set(data.map(row => row.annee))].sort((a, b) => b - a);
                    this.currentPage = 1;
                });
        },
        filteredSoldeConges() {
            let filtered = this.soldeConges;
            let year = this.selectedYear === '__edit__' ? this.customYear : this.selectedYear;
            if (year) {
                filtered = filtered.filter(row => row.annee == year);
            }
            if (this.search && this.search.trim() !== '') {
                const s = this.search.trim().toLowerCase();
                filtered = filtered.filter(row => (row.nom || '').toLowerCase().includes(s));
            }
            return filtered;
        },
        paginatedSoldeConges() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredSoldeConges().slice(start, start + this.perPage);
        },
        totalPages() {
            return Math.max(1, Math.ceil(this.filteredSoldeConges().length / this.perPage));
        }
    }
}
</script>

