<div x-data="congePage()" x-init="init(); fetchEmployes(); fetchConges();" x-show="active === 'conge'" class="animate-fade-in">
  <!-- Debug Panel -->
  <!-- Debug Info supprimé -->

  <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
    <button
      class="px-4 py-2 bg-gradient-to-r from-blue-100 to-blue-300 text-blue-800 dark:from-blue-900 dark:to-blue-700 dark:text-blue-200 rounded-lg font-semibold shadow hover:from-blue-200 hover:to-blue-400 dark:hover:from-blue-800 dark:hover:to-blue-600 transition"
      @click="active = 'solde_conge'"
      type="button"
    >
      <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 4v16m8-8H4"/>
      </svg>
       Solde annee suivante 
    </button>
    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
      <div class="flex items-center space-x-2">
        <label class="text-sm text-gray-600 dark:text-gray-300">Année :</label>
        <select x-model="selectedYear" class="px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm">
          <option value="">Toutes</option>
          <template x-for="year in years" :key="year">
            <option :value="year" x-text="year"></option>
          </template>
          <option value="__edit__">Autre...</option>
        </select>
        <template x-if="selectedYear === '__edit__'">
          <input
            type="number"
            min="1900"
            max="2100"
            x-model="customYear"
            @change="
              if(customYear && !years.includes(Number(customYear))) {
                years.push(Number(customYear));
                years.sort((a,b)=>b-a);
              }
              selectedYear = customYear;
            "
            placeholder="Entrer une année"
            class="ml-2 px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm w-24"
          >
        </template>
      </div>
      <div class="flex items-center space-x-2">
        <label class="text-sm text-gray-600 dark:text-gray-300">Employé :</label>
        <input
          type="text"
          x-model="search"
          placeholder="Rechercher un employé..."
          class="px-2 py-1 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm"
        >
      </div>
    </div>
    <button
      class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-blue-500/25 transform hover:scale-105"
      @click="showAddForm = true"
    >
      <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 4v16m8-8H4"/>
      </svg>
      Nouvelle demande
    </button>
  </div>

  <!-- Modal : Formulaire d'ajout de congé -->
  <div
    x-show="showAddForm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    style="display: none;">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-8 relative" @click.away="showAddForm = false">
      <button
        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
        @click="showAddForm = false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <h3 class="text-xl font-bold mb-4">Nouvelle demande de congé</h3>
      <form @submit.prevent="submitConge">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium mb-1">Employé *</label>
            <select class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.employe_id" required>
              <option value="">Sélectionner un employé</option>
              <template x-for="emp in employes" :key="emp.id">
                <option :value="emp.id" x-text="emp.nom + ' ' + (emp.prenom || '')"></option>
              </template>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Semestre</label>
            <select class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.semestre"
              @change="
                if(form.semestre === 'Semestre 1') {
                  form.duree = 12;
                  form.solde_conges = '';
                } else {
                  form.duree = '';
                  form.solde_conges = '';
                } ">
              <option value="">Sélectionner le semestre</option>
              <option value="Semestre 1">Semestre 1</option>
              <option value="Semestre 2">Semestre 2</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Date début *</label>
            <input type="date" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.date_debut" required
              @change="
                if(form.semestre === 'Semestre 1' && form.date_debut) {
                  let d = new Date(form.date_debut);
                  d.setDate(d.getDate() + 11);
                  form.date_fin = d.toISOString().slice(0,10);
                } ">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Date fin *</label>
            <input type="date" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.date_fin" required
              :readonly="form.semestre === 'Semestre 1'">
          </div>
          <template x-if="form.semestre === 'Semestre 1'">
            <div>
              <label class="block text-sm font-medium mb-1">Durée</label>
              <input type="number" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
                x-model="form.duree" readonly>
            </div>
          </template>
          <div class="md:col-span-2 hidden">
            <label class="block text-sm font-medium mb-1">Type de congé</label>
            <input type="text"
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200"
              :value="(() => {
                let commentaire = 'Congé normal';
                if (form.employe_id && form.semestre) {
                  const s2Count = conges.filter(c => c.employe_id == form.employe_id && c.semestre === 'Semestre 2').length;
                  if (form.semestre === 'Semestre 2' && s2Count > 0) {
                    commentaire = 'Congé exceptionnel';
                  } else {
                    commentaire = 'Congé normal';
                  }
                }
                return commentaire;
              })()"
              readonly>
          </div>
          <input type="hidden" x-model="form.commentaire">
        </div>
        <template x-if="formErrors && Object.keys(formErrors).length">
          <div class="md:col-span-2 mt-4">
            <ul class="bg-red-100 border border-red-300 text-red-700 rounded-lg px-4 py-3 space-y-1 text-sm">
              <template x-for="(messages, field) in formErrors" :key="field">
                <template x-for="msg in messages" :key="msg">
                  <li x-text="msg"></li>
                </template>
              </template>
            </ul>
          </div>
        </template>
        <div class="flex justify-end space-x-2 mt-8">
          <button type="button" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600"
            @click="showAddForm = false">Annuler</button>
          <button type="submit" class="px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50" :disabled="loading">
            <span x-show="!loading">Valider</span>
            <span x-show="loading" class="flex items-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Traitement...
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast de confirmation amélioré -->
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
    aria-live="polite" >
    <div class="flex items-center px-4 py-3 rounded-lg shadow-lg space-x-3"
      :class="toastType === 'error' ? 'bg-red-500 text-white' : 'bg-green-500 text-white'">
      <svg x-show="toastType !== 'error'" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <svg x-show="toastType === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span x-text="toastMessage"></span>
    </div>
  </div>

  <!-- Tableau des congés -->
  <div class="glass-effect rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/20 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800">
      <h4 class="text-xl font-bold text-blue-800 dark:text-blue-200 tracking-wide flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        Demandes de congé
      </h4>
    </div>
    <!-- Loading state -->
    <div x-show="loading && conges.length === 0" class="px-6 py-8 text-center">
      <div class="flex items-center justify-center">
        <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="ml-2 text-blue-700 dark:text-blue-200 font-semibold">Chargement des congés...</span>
      </div>
    </div>
    <div class="overflow-x-auto" x-show="!loading || conges.length > 0">
      <table class="w-full text-sm">
        <thead class="bg-gradient-to-r from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800">
          <tr>
            <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Employé</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Semestre</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Date début</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Date fin</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Durée (Jours)</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Date d'approbation</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Type de conge</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Solde congés actuel</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Utilisateur</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-blue-100 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <template x-for="conge in paginatedConges()" :key="conge.id">
            <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/40 transition">
              <td class="px-4 py-3 font-medium flex items-center">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white font-bold mr-2"
                  x-text="conge.employe ? ((conge.employe.nom ? conge.employe.nom[0] : '') + (conge.employe.prenom ? conge.employe.prenom[0] : '')) : '?'"></span>
                <span x-text="conge.employe ? (conge.employe.nom + ' ' + (conge.employe.prenom || '')) : 'Cet employé n\'existe pas ou a été supprimé'"
                  :class="conge.employe ? 'text-gray-900 dark:text-blue-100' : 'text-red-500'"></span>
                <template x-if="conge.employe && conge.employe.email">
                  <span class="ml-2 text-xs text-gray-500 dark:text-blue-200" x-text="conge.employe.email"></span>
                </template>
              </td>
              <td class="px-4 py-3 text-center">
                <span class="inline-block px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 font-semibold" x-text="conge.semestre || '-'"></span>
              </td>
              <td class="px-4 py-3 text-center" x-text="formatDate(conge.date_debut)"></td>
              <td class="px-4 py-3 text-center" x-text="formatDate(conge.date_fin)"></td>
              <td class="px-4 py-3 text-center font-medium">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200"
                  x-text="conge.duree + ' jour' + (conge.duree > 1 ? 's' : '')"></span>
              </td>
              <td class="px-4 py-3 text-center" x-text="formatDate(conge.date_approbation)"></td>
              <td class="px-4 py-3">
                <template x-if="conge.commentaire">
                  <span class="inline-block max-w-xs truncate px-2 py-1 rounded bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-200" :title="conge.commentaire" x-text="conge.commentaire"></span>
                </template>
                <template x-if="!conge.commentaire">
                  <span class="text-gray-400">-</span>
                </template>
              </td>
              <td class="px-4 py-3 text-center">
                <template x-if="conge.solde_conges !== null && conge.solde_conges !== undefined">
                  <span class="inline-flex items-center px-2 py-1 rounded-full font-bold"
                    :class="conge.solde_conges > 0
                      ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                      : (conge.solde_conges < 0
                        ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'
                        : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200')"
                    x-text="conge.solde_conges"></span>
                </template>
                <template x-if="conge.solde_conges === null || conge.solde_conges === undefined">
                  <span class="text-gray-400">-</span>
                </template>
              </td>
              <td class="px-4 py-3 text-center">
                <template x-if="conge.user && conge.user.name">
                  <span class="text-gray-600 dark:text-blue-200" x-text="conge.user.name"></span>
                </template>
                <template x-if="!conge.user || !conge.user.name">
                  <span class="text-gray-400">-</span>
                </template>
              </td>
              <td class="px-4 py-3 text-center">
                <div class="flex space-x-2 justify-center">
                  <button class="p-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors shadow" title="Voir"
                    @click="viewConge(conge)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12s-4.5 7.5-10.5 7.5S1.5 12 1.5 12Z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                  <button
                    class="p-2 bg-yellow-400 text-white rounded-full hover:bg-yellow-500 transition-colors shadow"
                    title="Modifier"
                    @click="editConge(conge)"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6l11-11a2.828 2.828 0 00-4-4L5 17v4z"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </template>
          <tr x-show="!loading && paginatedConges().length === 0">
            <td colspan="10" class="px-4 py-8 text-center text-gray-500">
              <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg font-medium">Aucune demande de congé</p>
                <p class="text-sm">Aucun résultat pour votre recherche</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Pagination controls -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 border-t border-gray-200 dark:border-gray-700" x-show="totalCongePages() > 1">
      <div class="text-sm text-gray-500 mb-2 md:mb-0" x-text="`Page ${congePage} sur ${totalCongePages()}`"></div>
      <div class="flex flex-wrap gap-1">
        <button
          class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
          :disabled="congePage === 1"
          @click="congePage--"
        >Précédent</button>
        <template x-for="page in totalCongePages()" :key="page">
          <button
            class="px-3 py-1 rounded-lg"
            :class="congePage === page ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-800'"
            @click="congePage = page"
            x-text="page"
          ></button>
        </template>
        <button
          class="px-3 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-blue-200 dark:hover:bg-blue-800 transition"
          :disabled="congePage === totalCongePages()"
          @click="congePage++"
        >Suivant</button>
      </div>
    </div>
  </div>

  <!-- Modal Voir Congé -->
  <div
    x-show="showViewConge"
    style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
  >
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-8 relative">
      <button
        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
        @click="showViewConge = false"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <h3 class="text-xl font-bold mb-4">Détail du congé</h3>
      <template x-if="selectedConge">
        <div class="space-y-2">
          <div><span class="font-semibold">Employé :</span> <span x-text="selectedConge.employe ? (selectedConge.employe.nom + ' ' + (selectedConge.employe.prenom || '')) : '-'"></span></div>
          <div><span class="font-semibold">Semestre :</span> <span x-text="selectedConge.semestre || '-'"></span></div>
          <div><span class="font-semibold">Date début :</span> <span x-text="formatDate(selectedConge.date_debut)"></span></div>
          <div><span class="font-semibold">Date fin :</span> <span x-text="formatDate(selectedConge.date_fin)"></span></div>
          <div><span class="font-semibold">Durée :</span> <span x-text="selectedConge.duree + ' jour' + (selectedConge.duree > 1 ? 's' : '')"></span></div>
          <div><span class="font-semibold">Date d'approbation :</span> <span x-text="formatDate(selectedConge.date_approbation)"></span></div>
          <div><span class="font-semibold">Commentaire :</span> <span x-text="selectedConge.commentaire || '-'"></span></div>
          <div><span class="font-semibold">Solde congés :</span> <span x-text="selectedConge.solde_conges"></span></div>
          <div><span class="font-semibold">Utilisateur :</span> <span x-text="selectedConge.user && selectedConge.user.name ? selectedConge.user.name : '-'"></span></div>
        </div>
      </template>
    </div>
  </div>

  <!-- Modal : Formulaire de modification de congé -->
  <div
    x-show="showEditForm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    style="display: none;"
  >
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-8 relative" @click.away="showEditForm = false">
      <button
        class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
        @click="showEditForm = false"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <h3 class="text-xl font-bold mb-4">Modifier le congé</h3>
      <form @submit.prevent="submitEditConge">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium mb-1">Employé *</label>
            <select class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="editForm.employe_id" required>
              <option value="">Sélectionner un employé</option>
              <template x-for="emp in employes" :key="emp.id">
                <option :value="emp.id" x-text="emp.nom + ' ' + (emp.prenom || '')"></option>
              </template>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Semestre</label>
            <select class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="editForm.semestre"
              @change="
                if(editForm.semestre === 'Semestre 1') {
                  editForm.duree = 12;
                  editForm.solde_conges = '';
                } else {
                  editForm.duree = '';
                  editForm.solde_conges = '';
                } ">
              <option value="">Sélectionner le semestre</option>
              <option value="Semestre 1">Semestre 1</option>
              <option value="Semestre 2">Semestre 2</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Date début *</label>
            <input type="date" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="editForm.date_debut" required
              @change="
                if(editForm.semestre === 'Semestre 1' && editForm.date_debut) {
                  let d = new Date(editForm.date_debut);
                  d.setDate(d.getDate() + 11);
                  editForm.date_fin = d.toISOString().slice(0,10);
                } ">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Date fin *</label>
            <input type="date" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="editForm.date_fin" required
              :readonly="editForm.semestre === 'Semestre 1'">
          </div>
          <template x-if="editForm.semestre === 'Semestre 1'">
            <div>
              <label class="block text-sm font-medium mb-1">Durée</label>
              <input type="number" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
                x-model="editForm.duree" readonly>
            </div>
          </template>
          <div class="md:col-span-2 hidden">
            <label class="block text-sm font-medium mb-1">Type de congé</label>
            <input type="text"
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200"
              :value="(() => {
                let commentaire = 'Congé normal';
                if (editForm.employe_id && editForm.semestre) {
                  const s2Count = conges.filter(c => c.employe_id == editForm.employe_id && c.semestre === 'Semestre 2').length;
                  if (editForm.semestre === 'Semestre 2' && s2Count > 0) {
                    commentaire = 'Congé exceptionnel';
                  } else {
                    commentaire = 'Congé normal';
                  }
                }
                return commentaire;
              })()"
              readonly>
          </div>
          <input type="hidden" x-model="editForm.commentaire">
        </div>
        <template x-if="formErrors && Object.keys(formErrors).length">
          <div class="md:col-span-2 mt-4">
            <ul class="bg-red-100 border border-red-300 text-red-700 rounded-lg px-4 py-3 space-y-1 text-sm">
              <template x-for="(messages, field) in formErrors" :key="field">
                <template x-for="msg in messages" :key="msg">
                  <li x-text="msg"></li>
                </template>
              </template>
            </ul>
          </div>
        </template>
        <div class="flex justify-end space-x-2 mt-8">
          <button type="button" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600" @click="showEditForm = false">Annuler</button>
          <button type="submit" class="px-6 py-3 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 font-semibold">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

function congePage() {
  return {
    showAddForm: false,
    loading: false,
    showToast: false,
    toastMessage: '',
    toastType: 'success',
    employes: [],
    conges: [],
    form: {
      employe_id: '',
      semestre: '',
      date_debut: '',
      date_fin: '',
      commentaire: '',
      duree: '',
      solde_conges: ''
    },
    showEditForm: false,
    editForm: {
      id: '',
      employe_id: '',
      semestre: '',
      date_debut: '',
      date_fin: '',
      commentaire: '',
      duree: '',
      solde_conges: ''
    },
    congeSearch: '',
    congeSort: 'date_debut',
    congeSortOrder: 'desc',
    showViewConge: false,
    selectedConge: null,
    congePage: 1,
    congePerPage: 10,
    formErrors: {},
    years: [],
    selectedYear: '',
    customYear: '',
    search: '',

    init() {
      window.addEventListener('employe-deleted', () => {
        this.fetchConges();
      });
    },

    async fetchEmployes() {
      try {
        console.log('🔄 Récupération des employés...');
        const response = await fetch('/employes', {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (!response.ok) {
          throw new Error(`Erreur HTTP: ${response.status}`);
        }

        const data = await response.json();
        this.employes = Array.isArray(data) ? data : [];
        console.log('✅ Employés récupérés:', this.employes.length);
      } catch (error) {
        console.error('❌ Erreur employés:', error);
        this.showToastMessage('Erreur lors du chargement des employés: ' + error.message, 'error');
        this.employes = [];
      }
    },

    async fetchConges() {
      try {
        this.loading = true;
        console.log('🔄 Récupération des congés...');

        const response = await fetch('/conges', {
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (!response.ok) {
          throw new Error(`Erreur HTTP: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        this.conges = Array.isArray(data) ? data.map(c => {
          if (!c.user && c.users_id) c.user = {};
          return c;
        }) : [];
        this.years = [...new Set(this.conges.map(row => {
          if (row.date_debut) {
            return new Date(row.date_debut).getFullYear();
          }
          return null;
        }).filter(Boolean))].sort((a, b) => b - a);
        console.log('✅ Congés récupérés:', this.conges.length);
      } catch (error) {
        console.error('❌ Erreur congés:', error);
        this.showToastMessage('Erreur lors du chargement des congés: ' + error.message, 'error');
        this.conges = [];
      } finally {
        this.loading = false;
      }
    },

    async submitConge() {
      this.loading = true;
      this.formErrors = {};

      try {
        let commentaire = 'Congé normal';

       if (this.form.employe_id && this.form.semestre) {
            const s2Count = this.conges.filter(c => 
                c.employe_id == this.form.employe_id &&
                c.semestre === 'Semestre 2' &&
                new Date(c.date_debut).getFullYear() === new Date(this.form.date_debut).getFullYear()
            ).length;

          if (this.form.semestre === 'Semestre 2') {
            if (s2Count >= 1) {
              commentaire = 'Congé exceptionnel';
              if (this.form.date_debut) {
                let d = new Date(this.form.date_debut);
                d.setDate(d.getDate() + 1);
                this.form.date_fin = d.toISOString().slice(10);
                this.form.duree = 2;
              }
            } else {
              commentaire = 'Congé normal';
            }
          }

          this.form.commentaire = commentaire;

          if (this.form.semestre === 'Semestre 1') {
            this.form.duree = 12;
            this.form.solde_conges = '';
          } else if (this.form.semestre === 'Semestre 2') {
            if (this.form.date_debut && this.form.date_fin) {
              const d1 = new Date(this.form.date_debut);
              const d2 = new Date(this.form.date_fin);
              const duree = Math.floor((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
              if (duree > 12) {
                this.formErrors = { duree: ['La durée ne peut pas dépasser 12 jours pour le semestre 2.'] };
                this.loading = false;
                return;
              }
            }
          }
        }

        if (!this.form.employe_id || !this.form.date_debut || !this.form.date_fin) {
          throw new Error('Veuillez remplir tous les champs obligatoires');
        }

        if (new Date(this.form.date_fin) < new Date(this.form.date_debut)) {
          this.formErrors = { date_fin: ['La date de fin doit être postérieure à la date de début.'] };
          this.loading = false;
          return;
        }

        console.log('📤 Envoi des données:', this.form);

        const response = await fetch('/conges', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(this.form)
        });

        const responseData = await response.json();
        if (!response.ok) {
          if (response.status === 422) {
            const errors = responseData.errors || {};
            this.formErrors = errors;
            this.loading = false;
            return;
          } else {
            this.showToastMessage(
              (responseData.message || 'Erreur lors de la création du congé') +
              (responseData.error ? ' : ' + responseData.error : ''),
              'error'
            );
            this.loading = false;
            return;
          }
        }

        this.formErrors = {};
        this.showAddForm = false;
        this.resetForm();
        this.showToastMessage('Demande de congé ajoutée avec succès.', 'success');
        await this.fetchConges();

      } catch (error) {
        this.showToastMessage(error.message, 'error');
      } finally {
        this.loading = false;
      }
    },

    editConge(conge) {
      this.editForm = { ...conge };
      this.showEditForm = true;
    },
    async submitEditConge() {
      this.loading = true;
      try {
        const response = await fetch(`/conges/${this.editForm.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(this.editForm)
        });
        const responseData = await response.json();
        if (!response.ok) {
          this.showToastMessage(responseData.message || 'Erreur lors de la modification du congé', 'error');
          this.loading = false;
          return;
        }
        this.showEditForm = false;
        this.showToastMessage('Congé modifié avec succès.', 'success');
        await this.fetchConges();
      } catch (error) {
        this.showToastMessage(error.message, 'error');
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.form = {
        employe_id: '',
        semestre: '',
        date_debut: '',
        date_fin: '',
        commentaire: '',
        duree: '',
        solde_conges: ''
      };
      this.editForm = {
        id: null,
        employe_id: '',
        semestre: '',
        date_debut: '',
        date_fin: '',
        commentaire: '',
        duree: '',
        solde_conges: ''
      };
    },

    showToastMessage(message, type = 'success') {
      this.toastMessage = message;
      this.toastType = type;
      this.showToast = true;

      setTimeout(() => {
        this.showToast = false;
      }, type === 'error' ? 5000 : 3000);
    },

    formatDate(date) {
      if (!date) return '-';

      try {
        if (typeof date === 'string' && date.includes('/')) {
          return date;
        }

        const d = new Date(date);
        if (isNaN(d.getTime())) {
          return date;
        }

        return d.toLocaleDateString('fr-FR');
      } catch (error) {
        console.error('❌ Erreur formatage date:', error, date);
        return date;
      }
    },

    filteredSortedConges() {
      let search = this.search ? this.search.toLowerCase() : this.congeSearch.toLowerCase();
      let sort = this.congeSort;
      let order = this.congeSortOrder;
      let year = this.selectedYear === '__edit__' ? this.customYear : this.selectedYear;
      let list = this.conges.filter(c => {
        let matchYear = true;
        if (year) {
          const y = c.date_debut ? new Date(c.date_debut).getFullYear().toString() : '';
          matchYear = y == year;
        }
        let employe = c.employe ? ((c.employe.nom || '') + ' ' + (c.employe.prenom || '')) : '';
        let matchEmploye = !search || employe.toLowerCase().includes(search) ||
          (c.type || '').toLowerCase().includes(search) ||
          (c.commentaire || '').toLowerCase().includes(search) ||
          (c.semestre || '').toLowerCase().includes(search);
        return matchYear && matchEmploye;
      });

      list.sort((a, b) => {
        let va, vb;
        if (sort === 'employe') {
          va = a.employe ? ((a.employe.nom || '') + ' ' + (a.employe.prenom || '')) : '';
          vb = b.employe ? ((b.employe.nom || '') + ' ' + (b.employe.prenom || '')) : '';
          va = (va || '').toLowerCase();
          vb = (vb || '').toLowerCase();
          return order === 'asc' ? va.localeCompare(vb) : vb.localeCompare(va);
        }
        if (sort === 'semestre1') {
          va = a.semestre === 'Semestre 1' ? 0 : 1;
          vb = b.semestre === 'Semestre 1' ? 0 : 1;
          return order === 'asc' ? va - vb : vb - va;
        }
        if (sort === 'semestre2') {
          va = a.semestre === 'Semestre 2' ? 0 : 1;
          vb = b.semestre === 'Semestre 2' ? 0 : 1;
          return order === 'asc' ? va - vb : vb - va;
        }
        return 0;
      });
      return list;
    },
    toggleCongeSortOrder() {
      this.congeSortOrder = this.congeSortOrder === 'asc' ? 'desc' : 'asc';
    },
    congePageToFirst() {
      this.congePage = 1;
    },
    paginatedConges() {
      const start = (this.congePage - 1) * this.congePerPage;
      return this.filteredSortedConges().slice(start, start + this.congePerPage);
    },
    totalCongePages() {
      return Math.max(1, Math.ceil(this.filteredSortedConges().length / this.congePerPage));
    },
    viewConge(conge) {
      this.selectedConge = conge;
      this.showViewConge = true;
    },
    editConge(conge) {
      this.editForm = { ...conge };
      this.showEditForm = true;
    },
  }
}
</script>
