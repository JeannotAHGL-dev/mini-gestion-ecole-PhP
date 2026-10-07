<?php
include "connexion.php";

// Récupérer toutes les publications 
$requete = "SELECT * FROM filiere";
$execution = mysqli_query($connexion, $requete);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecole - Ajouter un etudiant</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="fixed-top mb-3">
        <?php include('menu.php'); ?>
    </div>
    <div class="fixed-top mb-3">
    
    </div>

    <div class="container mt-5 pt-5">
    <h4 class="pt-3 mb-3 text-primary fw-bold">Ajouter un etudiant  </h4>

    <!-- Alerte de succès -->
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
    Etudiant ajouté avec succès !
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>


   <!-- Alerte d'erreur avec détails -->
<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?php 
    $error_code = $_GET['error'];
    $error_messages = [
        '1' => 'Le fichier n\'est pas une image valide.',
        '2' => 'La taille de l\'image dépasse 5 Mo.',
        '3' => 'Format d\'image non autorisé (utilisez JPG, PNG, JPEG ou GIF).',
        '4' => 'Erreur lors de l\'enregistrement dans la base de données.',
        '5' => 'Erreur lors de l\'upload du fichier.'
    ];
    
    if (isset($error_messages[$error_code])) {
        echo $error_messages[$error_code];
    } else {
        echo 'Une erreur est survenue. Veuillez réessayer.';
    }
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

    <!-- Formulaire d'ajout -->
    <form action="tr_ajouter_etu.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
    <label class="form-label fw-bold">Nom</label>
    <input type="text" class="form-control" name="nom" placeholder="Ex: AA01" required>
    </div>
    <div class="mb-3">
    <label class="form-label fw-bold">Prénoms</label>
    <input type="text" class="form-control" name="prenom" placeholder="Ex: AA01" required>
    </div>

    <div class="mb-3">
    <label class="form-label fw-bold">Sexe</label>
    <select class="form-select" name="sexe" required>
        <option value="en attente">Masculin</option>
        <option value="en cours">Feminin</option>

    </select>
    <label class="form-label fw-bold">Photo d'identité</label>
    <input type="file" class="form-control" name="image_etu" required>
    </div>
    <div class="form-group">
                <label><i class="fas fa-list me-2"></i>Selectionner une filiere</label>
                <select class="form-select" name="filiere" required>
                    <option value="">Choisir une filiere...</option>
                    
                        <?php foreach ($execution as $p): ?>
                        <option value="<?= $p['codfil'] ?>">
                            <?= htmlspecialchars($p['codfil'])  ?>  Libelle: <?= $p['libfil'] ?>
                        </option>
                        <?php endforeach; ?>
                   
                </select>
    </div>
            
    <button type="submit" class="btn btn-primary" name="submit">Ajouter l'étudiant</button>
    </form>
    </div>
</body>