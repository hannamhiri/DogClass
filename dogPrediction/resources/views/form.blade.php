@include('header')


    <!-- Bouton pour utiliser des hyperparamètres déjà utilisés -->
    <button type="button" style="float:right;" class="btn btn-primary m-3" onclick="fetchHyperparameters()">Hyperparamètres déjà utilisés</button>
    <button type="button" style="float:right;" class="btn btn-secondary m-3" onclick="fetchImageFolders()" data-toggle="modal" data-target="#imagesModal">Images déjà utilisées</button>



    <div class="container my-5 custom-margin-top">
    <!-- Modale pour afficher les hyperparamètres déjà utilisés -->
    <div class="modal fade" id="hyperparametersModal" tabindex="-1" aria-labelledby="hyperparametersModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="hyperparametersModalLabel">Hyperparamètres déjà utilisés</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <table id="hyperparametersTable" class="table table-bordered">
                      <thead>
                          <tr>
                              <th>Nom Modèle</th>
                              <th>Taux d'apprentissage</th>
                              <th>Époques</th>
                              <th>Taille Lot</th>
                              <th>Patience</th>
                              <th>Optimiseur</th>
                              <th>Monitor</th>
                              <th>Fonction Activation</th>
                              <th>Validation Split</th>
                              <th>Test Split</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody id="hyperparametersBody">
                          <!-- Les lignes seront ajoutées ici dynamiquement -->
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
  <!-- Modale pour afficher les dossiers d'images enregistrés -->
  

<div class="modal fade" id="imagesModal" tabindex="-1" aria-labelledby="imagesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="imagesModalLabel">Images déjà utilisées</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <ul id="imagesList" class="list-group">

              </ul>
          </div>
      </div>
  </div>
</div>
  

        <h2 class="text-center mb-4">Image Classification Setup</h2>
        
        <form id="hyperparametersForm" action="{{ route('hyperparametre.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
              <label for="imageFolder" class="col-sm-3 col-form-label">Sélectionnez un dossier d'images </label>
              <div class="col-sm-9">
                <input type="file" id="imageFolder" name="images[]" webkitdirectory multiple accept="image/*" onchange="displayThumbnails(this)" required>
              </div>
            </div>
      
            <div class="thumbnail-container" id="thumbnailContainer"></div>
      
            <div class="form-group row">
              <label for="learning_rate" class="col-sm-3 col-form-label">Taux d'apprentissage :</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="taux_app_input" name="taux_app" step="0.0001" min="0" max="1" value="0.001" required>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="epochs" class="col-sm-3 col-form-label">Nombre d'époques :</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="nb_epoque_input" name="nb_epoque" min="1" value="10" required>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="batch_size" class="col-sm-3 col-form-label">Taille du lot :</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="taille_lot_input" name="taille_lot" min="1" value="32" required>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="patience" class="col-sm-3 col-form-label">Patience :</label>
              <div class="col-sm-9">
                <input type="number" class="form-control" id="patience_input" name="patience" min="1" value="5" required>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="monitor" class="col-sm-3 col-form-label">Monitor :</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="monitor" name="monitor" value="val_loss" required>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="optimizer" class="col-sm-3 col-form-label">Optimiseur :</label>
              <div class="col-sm-9">
                <select class="form-control" id="optimiseur_input" name="optimiseur" required>
                  <option value="adam">Adam</option>
                  <option value="sgd">SGD</option>
                  <option value="rmsprop">RMSProp</option>
                </select>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="model_name" class="col-sm-3 col-form-label">Nom du modèle :</label>
              <div class="col-sm-9">
                <input type="text" class="form-control"  name="nom_modele" id="nom_modele_input" required>
              </div>
            </div>
      
            <div class="form-group row">
              <label for="activation_function" class="col-sm-3 col-form-label">Fonction d'activation :</label>
              <div class="col-sm-9">
                <select class="form-control" id="f_activation_input" name="f_activation" required>
                  <option value="relu">ReLU</option>
                  <option value="sigmoid">Sigmoid</option>
                  <option value="tanh">Tanh</option>
                  <option value="softmax">Softmax</option>
                </select>
              </div>
            </div>
      
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Validation Split :</label>
              <div class="col-sm-9">
                <div class="form-check form-check-inline">
                  <input id="val_split_input" class="form-check-input" type="radio" name="Val_split" id="val_split_0.2" value="0.2" checked>
                  <label class="form-check-label" for="val_split_0.2">
                    10% (0.1)
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input id="val_split_input" class="form-check-input" type="radio" name="Val_split" id="val_split_0.3" value="0.3">
                  <label class="form-check-label" for="val_split_0.3">
                    20% (0.2)
                  </label>
                </div>
              </div>
            </div>
      
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Test Split :</label>
              <div class="col-sm-9">
                <div class="form-check form-check-inline">
                  <input  id="test_split_input" class="form-check-input" type="radio" name="test_split" id="test_split_0.1" value="0.1" checked>
                  <label class="form-check-label" for="test_split_0.1">
                    10% (0.1)
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input  id="test_split_input" class="form-check-input" type="radio" name="test_split" id="test_split_0.2" value="0.2">
                  <label class="form-check-label" for="test_split_0.2">
                    20% (0.2)
                  </label>
                </div>
              </div>
            </div>
      
            <div class="form-group row justify-content-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <style>
      .custom-margin-top {
      margin-top: 120px !important
        }

      .thumbnail-container {
          display: flex;
          flex-wrap: wrap;
          gap: 15px;
          justify-content: center;
          margin-top: 20px;
          margin-bottom: 20px;
      }
  
      .thumbnail {
          position: relative;
          width: 120px;
          height: 120px;
          border-radius: 15px;
          overflow: hidden;
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
          transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
  
      .thumbnail img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          cursor: pointer;
      }
  
      .thumbnail:hover {
          transform: scale(1.05);
          box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
      }
  
      .delete-icon {
          position: absolute;
          top: 5px;
          right: 5px;
          background-color: rgba(255, 0, 0, 0.7);
          color: white;
          border-radius: 50%;
          width: 24px;
          height: 24px;
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;
          font-size: 16px;
      }
  
      .delete-icon:hover {
          background-color: rgba(255, 0, 0, 0.9);
      }
  </style>
  
  <script>
      function displayThumbnails(input) {
          const thumbnailContainer = document.getElementById('thumbnailContainer');
          thumbnailContainer.innerHTML = ''; // Réinitialiser les miniatures à chaque nouvelle sélection
  
          if (input.files) {
              Array.from(input.files).forEach((file, index) => {
                  const reader = new FileReader();
                  reader.onload = function(e) {
                      // Créer l'élément de miniature avec une option de suppression
                      const thumbnailDiv = document.createElement('div');
                      thumbnailDiv.classList.add('thumbnail');
                      
                      const img = document.createElement('img');
                      img.src = e.target.result;
                      img.alt = 'Miniature de l\'image';
                      
                      const deleteIcon = document.createElement('span');
                      deleteIcon.classList.add('delete-icon');
                      deleteIcon.innerHTML = '&times;'; // Icône de suppression
                      deleteIcon.onclick = () => thumbnailDiv.remove(); // Supprimer la miniature lorsqu'on clique sur l'icône
                      
                      thumbnailDiv.appendChild(img);
                      thumbnailDiv.appendChild(deleteIcon);
                      thumbnailContainer.appendChild(thumbnailDiv);
                  };
                  reader.readAsDataURL(file);
              });
          }
      }
  </script>
<script>
 function fetchHyperparameters() {
    fetch('{{ route('hyper.display') }}')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('hyperparametersBody');
            tableBody.innerHTML = '';

            // Afficher chaque hyperparamètre dans une ligne du tableau
            data.forEach(item => {
                const row = document.createElement('tr');

                // Créer les cellules pour chaque hyperparamètre
                row.innerHTML = `
                    <td>${item.nom_modele}</td>
                    <td>${item.taux_app}</td>
                    <td>${item.nb_epoque}</td>
                    <td>${item.taille_lot}</td>
                    <td>${item.patience}</td>
                    <td>${item.optimiseur}</td>
                     <td>${item.monitor}</td>
                    <td>${item.f_activation}</td>
                    <td>${item.Val_split}</td>
                    <td>${item.test_split}</td>
                    <td><button class="btn btn-primary" onclick="fillForm('${item.nom_modele}', ${item.taux_app}, ${item.nb_epoque}, ${item.taille_lot}, ${item.patience}, '${item.optimiseur}', '${item.f_activation}', ${item.Val_split}, ${item.test_split})">Utiliser</button>
                                          <button class="btn btn-primary">Supprimer</button>

                      </td>
                `;

                // Ajouter la ligne au tableau
                tableBody.appendChild(row);
            });

            // Ouvrir la modale après le chargement des données
            new bootstrap.Modal(document.getElementById('hyperparametersModal')).show();
        })
        .catch(error => console.error('Erreur:', error));
}
function fillForm(nom_modele, taux_app, nb_epoque, taille_lot, patience, optimiseur, f_activation, val_split, test_split) {
    // Remplir les champs du formulaire
    document.getElementById('nom_modele_input').value = nom_modele;
    document.getElementById('taux_app_input').value = taux_app;
    document.getElementById('nb_epoque_input').value = nb_epoque;
    document.getElementById('taille_lot_input').value = taille_lot;
    document.getElementById('patience_input').value = patience;
    document.getElementById('optimiseur_input').value = optimiseur;
    document.getElementById('monitor_input').value = monitor;
    document.getElementById('f_activation_input').value = f_activation;
    
    // Gérer les radios de Val_split et Test_split
    document.querySelectorAll('input[name="Val_split"]').forEach(input => {
        if (input.value == val_split) {
            input.checked = true;
        }
    });

    document.querySelectorAll('input[name="test_split"]').forEach(input => {
        if (input.value == test_split) {
            input.checked = true;
        }
    });

    // Fermer la modale après avoir rempli le formulaire
    const modal = new bootstrap.Modal(document.getElementById('hyperparametersModal'));
    modal.hide();
}


function fetchImageFolders() {
    $.ajax({
      url: '{{ url("/images") }}', // Full URL to avoid path issues 
        type: 'GET',
        success: function(data) {
            console.log("Données reçues :", data);  // Vérifiez les données dans la console
            const imagesList = $('#imagesList');
            imagesList.empty();

            if (data.length === 0) {
                imagesList.append('<li class="list-group-item">Aucun dossier trouvé.</li>');
            } else {
                data.forEach(directory => {
                    const listItem = `<li class="list-group-item">${directory.path}</li>`;
                    imagesList.append(listItem);
                });
            }
        },
        error: function(error) {
            console.error("Erreur lors de la récupération des dossiers d'images :", error);
        }
    });
}



</script>



@include('footer')