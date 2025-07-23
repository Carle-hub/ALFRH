<!-- Conteneur principal affiché lorsque la section 'employe' est active -->
<div x-show="active === 'employe'" class="animate-fade-in" x-data="employePage()" x-init="initEmployes()">
    <!-- Titre principal avec icône -->
    <div class="flex items-center mb-6 space-x-3">
        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center shadow-lg">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div>
            <h3 class="text-2xl font-bold mb-1 text-emerald-700 dark:text-emerald-300">Gestion des Employés</h3>
        </div>
    </div>

    <!-- Bouton pour ouvrir le formulaire d'ajout d'employé -->
    <div class="flex justify-end mb-4">
        <button
            class="px-7 py-3 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-xl shadow-lg font-semibold flex items-center gap-2 hover:from-emerald-600 hover:to-green-600 hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-400"
            @click="showAddForm = true"
        >
            <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un employé
        </button>
    </div>

    <!-- Modal : Formulaire d'ajout d'employé -->
    <div
        x-show="showAddForm"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-3xl p-8 relative border-t-8 border-emerald-400 dark:border-emerald-700">
            <button
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                @click="showAddForm = false"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <h3 class="text-xl font-bold mb-4 text-emerald-700 dark:text-emerald-300">Ajouter un employé</h3>
            <form @submit.prevent="submitEmploye">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nom et Prenoms</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400" x-model="form.nom" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400" x-model="form.email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Poste</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400" x-model="form.poste" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Département</label>
                        <select class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400" x-model="form.departement" required>
                            <option value="">Sélectionner</option>
                            <option value="Linguistique">Acceuil</option>
                            <option value="administration">Administration</option>
                            <option value="communication">Communication-Reprographie</option>
                            <option value="culturel">Culturel</option>
                            <option value="culturel">Femme de menage</option>
                            <option value="Logistique">Logistique</option>
                            <option value="culturel">Médiatheque</option>
                            <option value="Logistique">Pédagogie</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Adresse</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400" x-model="form.adresse">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Téléphone</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400" x-model="form.telephone">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-8">
                    <button type="button" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600" @click="showAddForm = false">Annuler</button>
                    <button type="submit" class="px-6 py-3 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 font-semibold">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal : Voir les détails d'un employé -->
    <div
        x-show="showViewModal"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-8 relative border-t-8 border-emerald-400 dark:border-emerald-700">
            <button
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                @click="showViewModal = false"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <h3 class="text-xl font-bold mb-4 text-emerald-700 dark:text-emerald-300">Détails de l'employé</h3>
            <template x-if="selectedEmploye">
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold text-white bg-gradient-to-br from-emerald-400 to-green-600 shadow" :class="selectedEmploye.avatarClass">
                            <span x-text="selectedEmploye.initials"></span>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-semibold" x-text="selectedEmploye.nom"></div>
                            <div class="text-sm text-gray-500" x-text="selectedEmploye.email"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div><span class="font-semibold">Poste :</span> <span x-text="selectedEmploye.poste"></span></div>
                        <div><span class="font-semibold">Département :</span> <span x-text="selectedEmploye.departement"></span></div>
                        <div><span class="font-semibold">Adresse :</span> <span x-text="selectedEmploye.adresse"></span></div>
                        <div><span class="font-semibold">Téléphone :</span> <span x-text="selectedEmploye.telephone"></span></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Modal : Modifier un employé -->
    <div
        x-show="showEditForm"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    >
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-3xl p-8 relative border-t-8 border-yellow-400 dark:border-yellow-700">
            <button
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                @click="showEditForm = false"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <h3 class="text-xl font-bold mb-4 text-yellow-700 dark:text-yellow-300">Modifier l'employé</h3>
            <form @submit.prevent="submitEditEmploye">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nom</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" x-model="editForm.nom" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" x-model="editForm.email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Poste</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" x-model="editForm.poste" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Département</label>
                        <select class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" x-model="editForm.departement" required>
                            <option value="">Sélectionner...</option>
                            <option value="Logistique">Logistique</option>
                            <option value="administration">Administration</option>
                            <option value="communication">Communication</option>
                            <option value="Linguistique">Linguistique</option>
                            <option value="culturel">Culturel</option>
                            <option value="femme de menage">Femme de ménage</option>
                            <option value="securiter">Sécurité</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Adresse</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" x-model="editForm.adresse">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Téléphone</label>
                        <input type="text" class="w-full px-5 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400" x-model="editForm.telephone">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-8">
                    <button type="button" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600" @click="showEditForm = false">Annuler</button>
                    <button type="submit" class="px-6 py-3 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 font-semibold">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmation de suppression moderne -->
    <div
        x-show="showDeleteModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        aria-modal="true" role="dialog"
    >
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl w-full max-w-md p-8 relative flex flex-col items-center animate-fade-in border-t-8 border-red-400 dark:border-red-700"
            @keydown.escape.window="cancelDeleteEmploye()"
            tabindex="0"
        >
            <svg class="w-16 h-16 text-red-500 mb-4 animate-bounce-subtle" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M15 9l-6 6M9 9l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <h3 class="text-xl font-bold mb-2 text-center text-red-600 dark:text-red-400">Confirmer la suppression</h3>
            <p class="mb-6 text-center text-gray-700 dark:text-gray-300">
                Êtes-vous sûr de vouloir supprimer
                <span class="font-semibold" x-text="employeToDelete?.nom"></span>
                <span class="text-gray-500" x-text="employeToDelete ? '(' + employeToDelete.email + ')' : ''"></span> ?
                <br>
                <span class="text-sm text-gray-500">Cette action est irréversible.</span>
            </p>
            <div class="flex space-x-4">
                <button @click="cancelDeleteEmploye()" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Annuler
                </button>
                <button @click="confirmDeleteEmploye()" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                    Supprimer
                </button>
            </div>
        </div>
    </div>

    <!-- Toast de confirmation -->
    <div
        x-show="showToast"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 z-50"
        style="display: none;"
        aria-live="polite"
    >
        <div class="flex items-center px-4 py-3 rounded-lg shadow-lg bg-green-500 text-white space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span x-text="toastMessage"></span>
            <span class="ml-2 px-2 py-0.5 rounded-full bg-white/20 text-xs font-bold" x-show="toastMessage.includes('ajouté')">Nouveau</span>
        </div>
    </div>

    <!-- Tableau des employés avec recherche, tri et pagination -->
    <div class="glass-effect rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/20 overflow-hidden">
        <!-- Entête du tableau -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-green-100 dark:from-emerald-900 dark:to-green-800">
            <h4 class="text-lg font-semibold text-emerald-700 dark:text-emerald-200 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
                </svg>
                Liste des employés
            </h4>
            <!-- Barre de recherche et tri -->
            <div class="mt-4 flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
                <!-- Champ de recherche -->
                <div class="flex-1">
                    <input
                        type="text"
                        placeholder="Rechercher un employé..."
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        x-model="employeSearch"
                        @input="currentPage = 1"
                    >
                </div>
                <!-- Sélecteur de tri + bouton ordre -->
                <div class="flex items-center space-x-2">
                    <select
                        class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        x-model="employeSort"
                        @change="setSort($event.target.value)"
                    >
                        <option value="nom">Nom</option>
                        <option value="departement">Département</option>
                    </select>
                    <button type="button"
                        class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                        @click="toggleSortOrder()"
                        :title="sortOrder === 'asc' ? 'Tri croissant' : 'Tri décroissant'"
                    >
                        <svg x-show="sortOrder === 'asc'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 15l7-7 7 7"/>
                        </svg>
                        <svg x-show="sortOrder === 'desc'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Corps du tableau -->
        <div class="overflow-x-auto no-scrollbar">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Poste</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Adresse</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Téléphone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider max-w-xs whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Boucle de génération des lignes d'employé -->
                    <template x-for="employe in paginatedEmployes()" :key="employe.id">
                        <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-900/40 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Avatar et nom -->
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gradient-to-br from-emerald-400 to-green-600 shadow" :class="employe.avatarClass">
                                        <span class="text-sm font-semibold text-white" x-text="employe.initials"></span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium" x-text="employe.nom"></div>
                                    </div>
                                </div>
                            </td>
                            <!-- Autres colonnes -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="employe.email"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="employe.poste"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="employe.departement"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="employe.adresse"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="employe.telephone"></td>
                            <!-- Actions disponibles -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2 flex items-center">
                                <button class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors" title="Voir" @click="viewEmploye(employe)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12s-4.5 7.5-10.5 7.5S1.5 12 1.5 12Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                                <button class="p-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition-colors" title="Modifier" @click="editEmploye(employe)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536M9 13l6.536-6.536a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13z"/>
                                    </svg>
                                </button>
                                <button class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors" title="Supprimer" @click="deleteEmploye(employe.id)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <!-- Message si aucun employé trouvé -->
                    <tr x-show="paginatedEmployes().length === 0">
                        <td colspan="7" class="text-center py-6 text-gray-400">Aucun employé trouvé.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="flex justify-between items-center px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
            <!-- Indicateur de page actuelle -->
            <div class="text-sm text-gray-500" x-text="`Page ${currentPage} sur ${totalPages()}`"></div>
            <!-- Contrôles de pagination -->
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                    :disabled="currentPage === 1"
                    @click="currentPage--"
                >Précédent</button>
                <template x-for="page in totalPages()" :key="page">
                    <button
                        class="px-3 py-1 rounded-lg"
                        :class="currentPage === page ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'"
                        @click="currentPage = page"
                        x-text="page"
                    ></button>
                </template>
                <button
                    class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                    :disabled="currentPage === totalPages()"
                    @click="currentPage++"
                >Suivant</button>
            </div>
        </div>
    </div>

  
</div>

<script>
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}
function employePage() {
    return {
        showAddForm: false,
        showEditForm: false,
        showViewModal: false,
        showDeleteModal: false,
        selectedEmploye: null,
        employeToDelete: null,
        form: {
            nom: '', email: '', poste: '', departement: '', adresse: '', telephone: ''
        },
        editForm: {
            id: null, nom: '', email: '', poste: '', departement: '', adresse: '', telephone: ''
        },
        employes: [],
        employeSearch: '',
        employeSort: 'nom',
        sortOrder: 'asc',
        currentPage: 1,
        perPage: 10,
        showToast: false,
        toastMessage: '',
        viewEmploye(employe) {
            this.selectedEmploye = employe;
            this.showViewModal = true;
        },
        initEmployes() {
            fetch('/employes')
                .then(r => r.json())
                .then(data => {
                    this.employes = data.map(e => this.decorateEmploye(e));
                });
        },
        decorateEmploye(e) {
            let initials = (e.nom || '').split(' ').map(x => x[0]).join('').toUpperCase().slice(0,2);
            let color = 'bg-gradient-to-br from-emerald-500 to-green-600';
            if (e.departement && e.departement.toLowerCase().includes('rh')) color = 'bg-gradient-to-br from-blue-500 to-indigo-600';
            if (e.departement && e.departement.toLowerCase().includes('admin')) color = 'bg-gradient-to-br from-yellow-500 to-orange-600';
            return {...e, initials, avatarClass: color};
        },
        submitEmploye() {
            fetch('/employes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify(this.form)
            })
            .then(async r => {
                if (!r.ok) {
                    const text = await r.text();
                    // Ajout : gestion du cas où la réponse n'est pas JSON (ex: page HTML)
                    if (text.startsWith('<!DOCTYPE html>')) {
                        alert('Votre session a expiré ou vous n\'êtes plus connecté. Veuillez vous reconnecter.');
                        window.location.reload();
                        throw new Error('Session expirée');
                    }
                    try {
                        const err = JSON.parse(text);
                        throw err;
                    } catch {
                        throw { message: text };
                    }
                }
                // Ajout : vérifier si la réponse est bien du JSON
                const contentType = r.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await r.text();
                    if (text.startsWith('<!DOCTYPE html>')) {
                        alert('Votre session a expiré ou vous n\'êtes plus connecté. Veuillez vous reconnecter.');
                        window.location.reload();
                        throw new Error('Session expirée');
                    }
                    throw { message: text };
                }
                return r.json();
            })
            .then(e => {
                this.employes.unshift(this.decorateEmploye(e));
                this.showAddForm = false;
                this.form = {nom: '', email: '', poste: '', departement: '', adresse: '', telephone: ''};
                this.showToastMessage(`Employé "${e.nom}" ajouté avec succès.`);
            })
            .catch(err => alert('Erreur lors de l\'ajout : ' + (err.message || JSON.stringify(err))));
        },
        editEmploye(employe) {
            this.editForm = {
                id: employe.id,
                nom: employe.nom,
                email: employe.email,
                poste: employe.poste,
                departement: employe.departement,
                adresse: employe.adresse,
                telephone: employe.telephone
            };
            this.showEditForm = true;
        },
        submitEditEmploye() {
            fetch(`/employes/${this.editForm.id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({
                    nom: this.editForm.nom,
                    email: this.editForm.email,
                    poste: this.editForm.poste,
                    departement: this.editForm.departement,
                    adresse: this.editForm.adresse,
                    telephone: this.editForm.telephone
                })
            })
            .then(async r => {
                if (!r.ok) {
                    const text = await r.text();
                    // Ajout : Affichage du code HTTP et du contenu de la réponse
                    alert('Erreur HTTP ' + r.status + ' : ' + text);
                    try {
                        const err = JSON.parse(text);
                        throw err;
                    } catch {
                        throw { message: text };
                    }
                }
                return r.json();
            })
            .then(e => {
                const idx = this.employes.findIndex(emp => emp.id === e.id);
                if (idx !== -1) this.employes[idx] = this.decorateEmploye(e);
                this.showEditForm = false;
                this.showToastMessage(`Employé "${e.nom}" modifié avec succès.`);
            })
            .catch(err => alert('Erreur lors de la modification : ' + (err.message || JSON.stringify(err))));
        },
        deleteEmploye(id) {
            this.employeToDelete = this.employes.find(e => e.id === id);
            this.showDeleteModal = true;
        },
        confirmDeleteEmploye() {
            if (!this.employeToDelete) return;
            fetch(`/employes/${this.employeToDelete.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            })
            .then(r => {
                if (r.ok) {
                    this.employes = this.employes.filter(e => e.id !== this.employeToDelete.id);
                    this.showDeleteModal = false;
                    this.showToastMessage(`Employé "${this.employeToDelete.nom}" supprimé avec succès.`);
                    this.employeToDelete = null;
                    // Ajout : notifier les autres composants
                    window.dispatchEvent(new CustomEvent('employe-deleted'));
                }
            });
        },
        cancelDeleteEmploye() {
            this.showDeleteModal = false;
            this.employeToDelete = null;
        },
        showToastMessage(msg) {
            this.toastMessage = msg;
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 2500);
        },
        setSort(sort) {
            this.employeSort = sort;
            this.currentPage = 1;
        },
        toggleSortOrder() {
            this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
        },
        filteredEmployes() {
            let search = this.employeSearch.toLowerCase();
            let sort = this.employeSort;
            let order = this.sortOrder;
            let list = this.employes.filter(e =>
                (e.nom||'').toLowerCase().includes(search) ||
                (e.email||'').toLowerCase().includes(search) ||
                (e.poste||'').toLowerCase().includes(search) ||
                (e.departement||'').toLowerCase().includes(search) ||
                (e.adresse||'').toLowerCase().includes(search) ||
                (e.telephone||'').toLowerCase().includes(search)
            );
            // Tri limité à nom et departement
            if (sort === 'nom') list.sort((a, b) => order === 'asc' ? (a.nom||'').localeCompare(b.nom||'') : (b.nom||'').localeCompare(a.nom||''));
            if (sort === 'departement') list.sort((a, b) => order === 'asc' ? (a.departement||'').localeCompare(b.departement||'') : (b.departement||'').localeCompare(a.departement||''));
            return list;
        },
        paginatedEmployes() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredEmployes().slice(start, start + this.perPage);
        },
        totalPages() {
            return Math.max(1, Math.ceil(this.filteredEmployes().length / this.perPage));
        }
    }
}
</script>
<!-- Le code JS Alpine.js utilise fetch pour interagir avec l'API Laravel pour CRUD employé -->
