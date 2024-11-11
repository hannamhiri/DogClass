@include('header')

<div class="container mt-5">
    <h2>Historique des Sessions d'Entraînement</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="w-15">Taille de Lot</th>
                <th class="w-20">Nombre d'Époques</th>
                <th class="w-15">Taux d'Apprentissage</th>
                <th class="w-15">Patience</th>
                <th class="w-15">Moniteur</th>
                <th class="w-15">Optimiseur</th>
                <th class="w-25">Nom du Modèle</th>
                <th class="w-20">Fonction d'Activation</th>
                <th class="w-20">Validation Split</th>
                <th class="w-20">Test Split</th>
                <th class="w-35">Dossier d'Images</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainingHistory as $session)
                <tr>
                    <td>{{ $session->hyperparameter->taille_lot ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->nb_epoque ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->taux_app ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->patience ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->monitor ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->optimiseur ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->nom_modele ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->f_activation ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->Val_split ?? 'Non spécifié' }}</td>
                    <td>{{ $session->hyperparameter->test_split ?? 'Non spécifié' }}</td>
                    <td>
                        <button class="btn btn-primary mr-md-4 py-3 px-4 btn-info-custom " onclick="openModal({{ $loop->index }})">Voir les images</button>

                        <!-- Modal pour afficher les images --->
                        <div class="modal fade" id="modal-{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $loop->index }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel-{{ $loop->index }}">Images de la Session</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if (!empty($session->images))
                                            <div id="carousel-{{ $loop->index }}" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach ($session->images as $key => $image)
                                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 modal-img" alt="Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carousel-{{ $loop->index }}" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Précédent</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carousel-{{ $loop->index }}" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Suivant</span>
                                                </a>
                                            </div>
                                        @else
                                            <p>Aucune image disponible pour cette session.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    .table {
    margin-bottom: 40px; /* Ajustez la valeur selon votre besoin */
}
.btn-info-custom {
    text-transform: none;
    letter-spacing: 0ch;
    margin-left: 20px;
    width: 150px;
    height:50px;
    
}

.btn-info-custom:focus {
    outline: none !important; /* Enlève le contour autour du bouton */
    box-shadow: none !important; /* Enlève l'ombre portée sur le bouton */
    background-color: #00bd56 !important; /* Empêche le changement de couleur de fond */
    border-color: #00bd56 !important; /* Empêche le changement de couleur de bordure */
}


    .modal-dialog.modal-fixed {
        max-width: 800px; 
        width: 800px;     
        height: 600px;    
    }

    .modal-img {
        width: 100%;     
        height: 550px;    
        object-fit: contain; 
    }

    .carousel-inner {
        height: 100%;
    }

    .carousel-item {
        height: 100%;
    }
</style>

<script>
    function openModal(index) {
        $('#modal-' + index).modal('show');
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@include('footer')
