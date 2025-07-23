<div x-data="absencePage()" x-init="init()" x-show="active === 'absence'" class="animate-fade-in">
  <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
    <div>
      <h3 class="text-3xl font-extrabold mb-2 text-red-600 dark:text-pink-300 tracking-tight flex items-center gap-2">
        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Gestion des Absences
      </h3>
      <p class="text-gray-600 dark:text-gray-400 text-base">Suivi des absences et présence des employés</p>
    </div>
    <button class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl shadow-lg hover:from-red-600 hover:to-pink-600 hover:shadow-red-500/25 transform hover:scale-105 flex items-center gap-2 transition-all duration-200"
      @click="showAddForm = true">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 4v16m8-8H4"/>
      </svg>
      <span class="font-semibold">Ajouter une absence</span>
    </button>
  </div>

  <!-- Modal : Formulaire d'ajout d'absence -->
  <div x-show="showAddForm" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-lg p-8 relative border-t-8 border-red-400 dark:border-pink-700">
      <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
        @click="showAddForm = false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <h3 class="text-xl font-bold mb-4 text-red-700 dark:text-pink-300 flex items-center gap-2">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Ajouter une absence
      </h3>
      <form @submit.prevent="submitAbsence">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium mb-1">Employé</label>
            <select class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.employe_id" required>
              <option value="">Sélectionner un employé</option>
              <template x-for="emp in employes" :key="emp.id">
                <option :value="emp.id" x-text="emp.nom"></option>
              </template>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Type d'absence</label>
            <select class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800" x-model="form.type" required>
              <option value="">Sélectionner</option>
              <option value="repos_maladie">Repos maladie</option>
              <option value="remplacement">Remplacement</option>
              <option value="recuperation">Récupération</option>
              <option value="permission">Permission</option>
              <option value="assistance_maternel">Assistance maternel</option>
              <option value="retard">Retard</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Date début</label>
            <input type="date" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.date_debut" required
              @change="updateDuree()">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Date retour</label>
            <input type="date" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.date_retour" required
              @change="updateDuree()">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Durée</label>
            <input type="number" min="1" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800"
              x-model="form.duree" readonly>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Commentaire</label>
            <textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800" x-model="form.justification" name="justification" placeholder="Saisir un commentaire..." rows="2"></textarea>
          </div>
        </div>
        <div class="flex justify-end space-x-2 mt-8">
          <button type="button" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all" @click="showAddForm = false">Annuler</button>
          <button type="submit" class="px-6 py-3 rounded-lg bg-gradient-to-r from-red-500 to-pink-500 text-white hover:from-red-600 hover:to-pink-600 font-semibold shadow-md transition-all">Ajouter</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Filtres -->
  <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type d'absence</label>
      <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-400">
        <option value="">Tous les types</option>
        <option value="repos_maladie">Repos maladie</option>
        <option value="remplacement">Remplacement</option>
        <option value="recuperation">Récupération</option>
        <option value="permission">Permission</option>
        <option value="assistance_maternel">Assistance maternel</option>
        <option value="retard">Retard</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut</label>
      <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-400">
        <option value="">Tous les statuts</option>
        <option value="en_attente">En attente</option>
        <option value="approuve">Approuvé</option>
        <option value="refuse">Refusé</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date début</label>
      <input type="date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-400">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date fin</label>
      <input type="date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-400">
    </div>
  </div>
  <div class="glass-effect rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/20 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-red-50 to-pink-100 dark:from-pink-900 dark:to-red-800">
      <h4 class="text-xl font-bold text-red-800 dark:text-pink-200 tracking-wide flex items-center">
        <svg class="w-6 h-6 mr-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        Liste des absences
      </h4>
    </div>
    <div class="overflow-x-auto" >
      <table class="w-full text-sm">
        <thead class="bg-gradient-to-r from-red-100 to-pink-200 dark:from-pink-900 dark:to-red-800">
          <tr>
            <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Employé</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Type</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Date début</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Date retour</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Durée</th>
            <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Justification</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Date approbation</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Utilisateur</th>
            <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-pink-100 uppercase tracking-wider">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <template x-for="absence in absences" :key="absence.id">
            <tr class="hover:bg-red-50 dark:hover:bg-pink-900/40 transition">
              <td class="px-4 py-3 font-medium flex items-center">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-red-400 to-pink-600 text-white font-bold mr-2"
                  x-text="absence.employe ? (absence.employe.nom ? absence.employe.nom[0] : '') + (absence.employe.prenom ? absence.employe.prenom[0] : '') : '?' "></span>
                <span x-text="absence.employe ? (absence.employe.nom + ' ' + (absence.employe.prenom || '')) : 'Cet employé n\'existe pas ou a été supprimé'"
                  :class="absence.employe ? 'text-gray-900 dark:text-pink-100' : 'text-red-500'"></span>
              </td>
              <td class="px-4 py-3 text-center">
                <span class="inline-block px-2 py-1 rounded-full bg-red-100 dark:bg-pink-800 text-red-700 dark:text-pink-200 font-semibold" x-text="absence.type || '-' "></span>
              </td>
              <td class="px-4 py-3 text-center" x-text="absence.date_debut"></td>
              <td class="px-4 py-3 text-center" x-text="absence.date_retour"></td>
              <td class="px-4 py-3 text-center font-medium">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200"
                  x-text="absence.duree + ' jour' + (absence.duree > 1 ? 's' : '')"></span>
              </td>
              <td class="px-4 py-3">
                <template x-if="absence.justification">
                  <span class="inline-block max-w-xs truncate px-2 py-1 rounded bg-red-50 dark:bg-pink-900/30 text-red-700 dark:text-pink-200" :title="absence.justification" x-text="absence.justification"></span>
                </template>
                <template x-if="!absence.justification">
                  <span class="text-gray-400">-</span>
                </template>
              </td>
              <td class="px-4 py-3 text-center" x-text="absence.date_approbation"></td>
              <td class="px-4 py-3 text-center">
                <template x-if="absence.user && absence.user.name">
                  <span class="text-gray-600 dark:text-pink-200" x-text="absence.user.name"></span>
                </template>
                <template x-if="!absence.user || !absence.user.name">
                  <span class="text-gray-400">-</span>
                </template>
              </td>
              <td class="px-4 py-3 text-center">
                <div class="flex space-x-2 justify-center">
                  <button class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow" title="Voir"
                    @click="alert('Détail absence : ' + (absence.employe ? absence.employe.nom : '') + ' du ' + absence.date_debut)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12s-4.5 7.5-10.5 7.5S1.5 12 1.5 12Z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </template>
          <tr x-show="absences.length === 0">
            <td colspan="9" class="px-6 py-12 text-center bg-white dark:bg-gray-900">
              <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Aucune absence enregistrée</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Commencez par ajouter une nouvelle absence</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
  </div>

 
</div>

<script>
function absencePage() {
  return {
    showAddForm: false,
    absences: [],
    employes: [],
    userId: null,
    form: {
      employe_id: '',
      type: '',
      date_debut: '',
      date_retour: '',
      duree: '',
      justification: ''
    },
    init() {
      this.fetchEmployes();
      this.setUserId();
      this.fetchAbsences();
    },
    fetchEmployes() {
      fetch('/employes', { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
          this.employes = Array.isArray(data) ? data : [];
        })
        .catch(() => alert('Erreur lors du chargement des employés'));
    },
    fetchAbsences() {
      fetch('/absences', { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
          this.absences = Array.isArray(data) ? data : [];
        })
        .catch(() => alert('Erreur lors du chargement des absences'));
    },
    setUserId() {
      fetch('/api/user', { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(user => {
          if (user?.id) {
            this.userId = user.id;
          }
        })
        .catch(() => alert('Impossible de récupérer l\'utilisateur connecté'));
    },
    updateDuree() {
      const d1 = new Date(this.form.date_debut);
      const d2 = new Date(this.form.date_retour);
      if (d1 instanceof Date && d2 instanceof Date && !isNaN(d1) && !isNaN(d2) && d2 >= d1) {
        const diffTime = Math.abs(d2 - d1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        this.form.duree = diffDays.toString();
      } else {
        this.form.duree = '';
      }
    },
    resetForm() {
      this.form = {
        employe_id: '',
        type: '',
        date_debut: '',
        date_retour: '',
        duree: '',
        justification: ''
      };
    },
    submitAbsence() {
      const dateApprobation = new Date().toISOString().slice(0, 10);

      const payload = {
        employe_id: this.form.employe_id,
        type: this.form.type,
        date_debut: this.form.date_debut,
        date_retour: this.form.date_retour,
        duree: this.form.duree,
        justification: this.form.justification,
        users_id: this.userId,
        date_approbation: dateApprobation
      };

      fetch('/absences', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(payload)
      })
      .then(async r => {
        const contentType = r.headers.get('content-type');
        const isJson = contentType && contentType.includes('application/json');
        const responseData = isJson ? await r.json() : await r.text();

        if (!r.ok) throw responseData;

        return responseData;
      })
      .then(data => {
        this.fetchAbsences();
        this.showAddForm = false;
        this.resetForm();
      })
      .catch(error => {
        console.error('Erreur ajout absence :', error);
        alert(error?.message || 'Erreur lors de l\'ajout de l\'absence');
      });
    }
  };
}
</script>
