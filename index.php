<?php
include "connexion.php";

// Récupérer toutes les publications 
$requete = "SELECT * FROM etudiant";
$execution = mysqli_query($connexion, $requete);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBLICATIONS - Liste des etudiants</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .btn-action {
            transition: all 0.3s ease;
            margin: 2px;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .btn-activer {
            min-width: 140px;
        }
        .badge-statut {
            font-size: 0.9em;
            padding: 8px 12px;
        }
    </style>
</head>
<body>
    <div class="fixed-top mb-3">
        <?php include('menu.php'); ?>
    </div>

    <div class="container mt-5 pt-5">
        <h4 class="pt-3 mb-3 text-primary fw-bold">
            <i class="fas fa-list me-2"></i>Liste de tous les etudiants
        </h4>

        <!-- Messages de notification -->
        <?php if (isset($_GET['delete'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-trash-alt me-2"></i>Pub supprimée avec succès !
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['activated'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Statut modifié avec succès !
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th style="width:120px;">Photo d'identité</th>
                        <th>Sexe</th>
                        <th>Filière</th>
                        <th style="width:300px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($execution) > 0): ?>
                        <?php while ($publication = mysqli_fetch_assoc($execution)): ?>
                        <tr>
                            <td class="text-center align-middle"><?php echo $publication['id']; ?></td>
                            
                            <td class="align-middle">
                                <?php echo htmlspecialchars($publication['nom']); ?>
                            </td>
                            <td class="align-middle">
                                <?php echo htmlspecialchars($publication['prenoms']); ?>
                            </td>
                            
                            <td class="text-center align-middle">
                                <?php
                                $imagePath = 'uploads/' . $publication['photo_identite'];
                                if (!empty($publication['photo_identite']) && file_exists($imagePath)) {
                                    echo '<img src="' . $imagePath . '" alt="Image de la pub" style="width:80px; height:80px; object-fit:cover; border-radius:5px;">';
                                } else {
                                    echo '<div class="bg-light d-flex align-items-center justify-content-center" style="width:80px; height:80px; border-radius:5px;">';
                                    echo '<i class="fas fa-image fa-2x text-muted"></i>';
                                    echo '</div>';
                                }
                                ?>
                            </td>
                            
                            <td class="text-center align-middle">
                                <?php if ($publication['sexe'] == 'Masculin'): ?>
                                    <span class="badge bg-warning text-dark badge-statut">
                                        <i class="fas fa-check-circle me-1"></i>Masculin
                                    </span>
                                <?php elseif ($publication['sexe'] == 'Feminin'): ?>
                                    <span class="badge bg-success badge-statut">
                                        <i class="fas fa-times-circle me-1"></i>Feminin
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary badge-statut">
                                        <i class="fas fa-clock me-1"></i>---
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle">
                                <?php echo htmlspecialchars($publication['codfil']); ?>
                            </td>
                            <td class="text-center align-middle">
                            

                                <!-- Bouton Modifier -->
                                <a class="btn btn-primary btn-sm btn-action"
                                   href="modifier.php?id=<?php echo $publication['id']; ?>"
                                   title="Modifier la publication">
                                    <i class="fas fa-edit me-1"></i> Modifier
                                </a>
                                
                                <!-- Bouton Supprimer -->
                                <a class="btn btn-danger btn-sm btn-action"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ? Cette action est irréversible.')"
                                   href="supprimer_pub.php?id=<?php echo $publication['id']; ?>"
                                   title="Supprimer la publication">
                                    <i class="fas fa-trash-alt me-1"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-info-circle me-2"></i>Aucune publication trouvée
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour améliorer l'expérience utilisateur -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Animation sur les boutons
        const buttons = document.querySelectorAll('.btn-action');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
</body>
</html>