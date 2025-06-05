<!DOCTYPE html>
<html lang="fr">
<head>
  <link href="{{ asset('css/reclamation.css') }}" rel="stylesheet">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Mes Réclamations</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            },
            secondary: {
              500: '#f59e0b',
            }
          },
          boxShadow: {
            'soft': '0 10px 30px -10px rgba(0, 0, 0, 0.1)',
            'hard': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'
          }
        }
      }
    }
  </script>
  <style>
    #fileContainer {
      padding: 12px;
      background-color: #f8fafc;
      border-radius: 8px;
      border: 1px dashed #cbd5e1;
    }

    #complaintFile:hover {
      text-decoration: underline;
    }

    .response-bubble {
      background-color: #f0f9ff;
      border-radius: 12px;
      border: 1px solid #e0f2fe;
    }
    
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.875rem;
      font-weight: 500;
    }
    
    .status-pending {
      background-color: #fef3c7;
      color: #92400e;
    }
    
    .status-in-progress {
      background-color: #dbeafe;
      color: #1e40af;
    }
    
    .status-resolved {
      background-color: #dcfce7;
      color: #166534;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    #responseContainer {
      animation: fadeIn 0.3s ease-out;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased text-slate-800 bg-gradient-to-br from-slate-50 to-slate-100">

@include('components.sideBar')
  
  <main class="main-content px-6 py-8">
    <div class="mx-auto" style="max-width: 95%;">
      <!-- Header Section -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div class="space-y-2">
          <h1 class="text-3xl md:text-3xl font-bold text-slate-800 modern-heading">Mes Réclamations</h1>
        </div>
        <button onclick="openNewModal()" class="btn-primary px-4 py-2 rounded-xl text-base font-medium flex items-center gap-2">
          <i class="fas fa-plus"></i>
          Nouvelle Réclamation
        </button>
      </div>

      <!-- Table Card -->
      <div class="card shadow-soft mb-10 p-1">
        <div class="table-container overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-8 py-5 text-left text-sm font-semibold text-slate-600 uppercase tracking-wider">Référence</th>
                <th class="px-8 py-5 text-left text-sm font-semibold text-slate-600 uppercase tracking-wider">Sujet</th>
                <th class="px-8 py-5 text-left text-sm font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                <th class="px-8 py-5 text-left text-sm font-semibold text-slate-600 uppercase tracking-wider">Statut</th>
                <th class="px-8 py-5 text-left text-sm font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
              @foreach ($reclamations as $reclamation)
              <tr class="table-row">
                <td class="px-8 py-5 whitespace-nowrap">
                  <span class="font-bold text-blue-600 text-lg">#REC-{{ $reclamation->id }}</span>
                </td>
                <td class="px-8 py-5">
                  <p class="font-semibold text-slate-800 text-lg">{{ $reclamation->sujet }}</p>
                  <p class="text-slate-500 text-sm mt-2 max-w-md">{{ Str::limit($reclamation->contenu, 70) }}</p>
                </td>
                <td class="px-8 py-5 whitespace-nowrap">
                  <div class="flex flex-col">
                    <span class="font-medium">{{ $reclamation->created_at->format('d/m/Y H:i') }}</span>
                    <span class="text-slate-400 text-sm">{{ $reclamation->created_at->diffForHumans() }}</span>
                  </div>
                </td>
                <td class="px-8 py-5 whitespace-nowrap">
                  <span class="status-badge 
                    {{ $reclamation->statut == 'en_attente' ? 'status-pending' : 
                       ($reclamation->statut == 'en_cours' ? 'status-in-progress' : 'status-resolved') }}">
                    <i class="fas fa-circle mr-2"></i>
                    {{ ucfirst(str_replace('_', ' ', $reclamation->statut)) }}
                  </span>
                </td>
                <td class="px-8 py-5 whitespace-nowrap">
                  <button onclick="viewComplaint(this)" 
                          data-id="{{ $reclamation->id }}"
                          data-sujet="{{ $reclamation->sujet }}"
                          data-contenu="{{ $reclamation->contenu }}"
                          data-date="{{ $reclamation->created_at }}"
                          data-statut="{{ $reclamation->statut }}"
                          data-reponse="{{ $reclamation->reponse ?? '' }}"
                          data-date-reponse="{{ $reclamation->updated_at }}"
                          data-fichier="{{ $reclamation->piece_jointe }}"
                          class="btn-secondary px-6 py-3 rounded-lg flex items-center gap-2 text-blue-600 hover:text-blue-800 transition-all">
                    <i class="far fa-eye"></i>
                    Consulter
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="flex flex-col md:flex-row justify-between items-center text-sm text-slate-500 gap-4">
        <p class="text-slate-600">Affichage de 1 à {{ count($reclamations) }} sur {{ count($reclamations) }} réclamation(s)</p>
        <div class="flex space-x-3">
          <button class="btn-secondary px-5 py-3 rounded-lg flex items-center gap-2" disabled>
            <i class="fas fa-chevron-left"></i>
            Précédent
          </button>
          <button class="btn-secondary px-5 py-3 rounded-lg flex items-center gap-2" disabled>
            Suivant
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>
  </main>

  <!-- Complaint Detail Modal -->
  <div id="complaintModal" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 hidden p-4">
    <div class="card w-full max-w-2xl modal-animation shadow-hard" style="max-height: 90vh; display: flex; flex-direction: column;">
      <div class="p-6 flex-shrink-0">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-2xl font-bold text-slate-800">Détails de la réclamation</h3>
            <div class="flex items-center space-x-4 mt-2">
              
            </div>
          </div>
          <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <div class="flex-grow px-6">
        <div class="space-y-4 mb-6">
          <div class="bg-slate-50 p-4 rounded-lg">
            <p class="text-sm text-slate-500 mb-1">Date de création :</p>
            <p id="complaintDate" class="font-medium"></p>
          </div>
        </div>

        <div class="bg-slate-50 p-6 rounded-lg mb-6">
          <h4 class="font-bold text-lg text-slate-800 mb-2">Réclamation portant sur :</h4>
          <p id="complaintSubject" class="font-medium text-slate-700 mb-4"></p>

          <h4 class="font-bold text-lg text-slate-800 mb-2">Description :</h4>
          <p id="complaintMessage" class="text-slate-600 whitespace-pre-line mb-6"></p>

          <div id="fileContainer" class="mt-6 hidden">
            <h4 class="font-bold text-lg text-slate-800 mb-2">Pièce jointe :</h4>
            <a id="complaintFile" href="#" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
              <i class="fas fa-paperclip"></i>
              <span id="fileName"></span>
            </a>
          </div>

          <div id="responseContainer" class="mt-6 hidden">
            <h4 class="font-bold text-lg text-slate-800 mb-2">Réponse de l'administration :</h4>
            <div class="response-bubble p-4">
              <div class="flex items-start gap-3">
                <div class="mt-1 flex-shrink-0">
                  <i class="fas fa-reply text-blue-500"></i>
                </div>
                <div>
                  <p id="complaintResponse" class="text-slate-700 whitespace-pre-line"></p>
                  <p class="text-sm text-blue-600 mt-2 flex items-center gap-1">
                    <i class="far fa-clock"></i>
                    <span id="responseDate"></span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="p-6 flex-shrink-0 border-t border-slate-100">
        <button onclick="closeModal()" class="btn-primary px-4 py-2 rounded-lg w-auto ml-auto">
          Fermer
        </button>
      </div>
    </div>
  </div>

  <!-- New Complaint Modal -->
  <div id="newComplaintModal" class="fixed inset-0 bg-black/30 flex items-center justify-center z-50 hidden p-4">
    <div class="card w-full max-w-2xl modal-animation shadow-hard" style="max-height: 90vh; display: flex; flex-direction: column;">
      <div class="p-6 flex-shrink-0">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Nouvelle réclamation</h3>
            <p class="text-slate-500">Remplissez le formulaire pour soumettre une nouvelle réclamation</p>
          </div>
          <button onclick="closeNewModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <div class="overflow-y-auto flex-grow px-6">
        <form action="{{ route('reclamations.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Sujet *</label>
              <input type="text" name="sujet" required 
                    class="input-field w-full rounded-lg px-4 py-3">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Message *</label>
              <textarea name="contenu" required rows="6" 
                        class="input-field w-full rounded-lg px-4 py-3"></textarea>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Pièce jointe</label>
              <div class="mt-1 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <label class="cursor-pointer">
                  <input type="file" name="piece_jointe" id="file-upload" class="sr-only">
                  <div class="btn-primary px-6 py-3 rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    Choisir un fichier
                  </div>
                </label>
                <div id="file-info" class="text-sm text-slate-500">
                  <span id="file-name">Aucun fichier sélectionné</span>
                  <span id="file-size" class="ml-2"></span>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="p-6 flex-shrink-0 border-t border-slate-100">
        <div class="flex justify-end space-x-4">
          <button type="button" onclick="closeNewModal()" class="btn-secondary px-6 py-3 rounded-lg">
            Annuler
          </button>
          <button type="submit" class="btn-primary px-6 py-3 rounded-lg">
            Envoyer la réclamation
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script>
   function adjustModalHeight() {
  const modals = ['complaintModal', 'newComplaintModal'];
  modals.forEach(modalId => {
    const modal = document.getElementById(modalId);
    if (modal && !modal.classList.contains('hidden')) {
      const viewportHeight = window.innerHeight;
      const maxModalHeight = viewportHeight * 0.9;
      modal.querySelector('.card').style.maxHeight = `${maxModalHeight}px`;
    }
  });
}

window.addEventListener('resize', adjustModalHeight);

function openNewModal() {
  document.getElementById("newComplaintModal").classList.remove("hidden");
  document.body.style.overflow = 'hidden';
  adjustModalHeight();
}

function closeNewModal() {
  document.getElementById("newComplaintModal").classList.add("hidden");
  document.body.style.overflow = 'auto';
}

function closeModal() {
  document.getElementById("complaintModal").classList.add("hidden");
  document.body.style.overflow = 'auto';
}

function viewComplaint(button) {
  const dataset = button.dataset;
  const dateCreation = new Date(dataset.date);
  
  const dateOptions = { 
    day: '2-digit', 
    month: '2-digit', 
    year: 'numeric',
    hour: '2-digit', 
    minute: '2-digit'
  };
  
  document.getElementById('complaintDate').textContent = dateCreation.toLocaleString('fr-FR', dateOptions);
  document.getElementById('complaintSubject').textContent = dataset.sujet || "Non spécifié";
  document.getElementById('complaintMessage').textContent = dataset.contenu || "Aucune description";

  // Gestion de la pièce jointe (partie corrigée)
  const fileContainer = document.getElementById('fileContainer');
  const complaintFileLink = document.getElementById('complaintFile');
  const fileNameElement = document.getElementById('fileName');

  if (dataset.fichier && dataset.fichier !== 'null' && dataset.fichier.trim() !== '') {
    const fileUrl = `/storage/${dataset.fichier}`;
    complaintFileLink.href = fileUrl;
    fileNameElement.textContent = dataset.fichier.split('/').pop();
    fileContainer.classList.remove('hidden');
  } else {
    fileContainer.classList.add('hidden');
  }

  const responseContainer = document.getElementById('responseContainer');
  const responseElement = document.getElementById('complaintResponse');
  const responseDateElement = document.getElementById('responseDate');
  
  if (dataset.reponse && dataset.reponse.trim() !== '' && dataset.reponse !== 'null') {
    responseElement.textContent = dataset.reponse;
    
    const responseDate = dataset.dateReponse ? new Date(dataset.dateReponse) : new Date(dataset.date);
    responseDateElement.textContent = `Répondu le ${responseDate.toLocaleDateString('fr-FR', dateOptions)}`;
    
    responseContainer.classList.remove('hidden');
  } else {
    responseContainer.classList.add('hidden');
  }

  document.getElementById("complaintModal").classList.remove("hidden");
  document.body.style.overflow = 'hidden';
  adjustModalHeight();
}

document.getElementById('file-upload')?.addEventListener('change', function() {
  const file = this.files[0];
  const fileName = document.getElementById('file-name');
  const fileSize = document.getElementById('file-size');
  
  if (file) {
    fileName.innerText = file.name;
    fileSize.innerText = `(${(file.size / 1024).toFixed(1)} Ko)`;
  } else {
    fileName.innerText = "Aucun fichier sélectionné";
    fileSize.innerText = "";
  }
});

  </script>
</body>
</html>