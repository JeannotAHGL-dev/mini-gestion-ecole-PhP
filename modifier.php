<?php
include 'connexion.php';

// Récupérer toutes les publications 
$requete = "SELECT * FROM filiere";
$execution = mysqli_query($connexion, $requete);

if (!isset($_GET['id'])) {
    header("location:index.php");
    exit;
}

$id = (int)$_GET['id'];
$req = "SELECT * FROM etudiant WHERE id = $id";
$res = mysqli_query($connexion, $req);
if (!$res || mysqli_num_rows($res) == 0) {
    header("location:index.php");
    exit;
}

$pub = mysqli_fetch_assoc($res);
$erreur = '';

if (isset($_POST['submit'])) {
    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $sexe  = mysqli_real_escape_string($connexion, $_POST['statut']);
    $filiere = mysqli_real_escape_string($connexion, $_POST['filiere']);

    // gestion de l'upload si l'utilisateur fournit un fichier
    $update_photo = false;
    if (isset($_FILES['image_etu']) && $_FILES['image_etu']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $image_name = time() . "_" . basename($_FILES["image_etu"]["name"]);
        $target_file = $target_dir . $image_name;
        $uploadOk    = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (getimagesize($_FILES["image_etu"]["tmp_name"]) === false) {
            $uploadOk = 0;
            $erreur = "Le fichier n'est pas une image valide.";
        }
        if ($_FILES["image_etu"]["size"] > 5000000) {
            $uploadOk = 0;
            $erreur = "La taille de l'image dépasse 5 Mo.";
        }
        if (!in_array($imageFileType, ['jpg','jpeg','png','gif'])) {
            $uploadOk = 0;
            $erreur = "Format d'image non autorisé (JPG, PNG, JPEG ou GIF).";
        }

        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES["image_etu"]["tmp_name"], $target_file)) {
                $update_photo = true;
                $pub['photo_identite'] = $image_name; // permet l'affichage après soumission
            } else {
                $erreur = "Erreur lors de l'upload du fichier.";
            }
        }
    }

    if ($erreur === '') {
        $req = "UPDATE etudiant SET nom='$nom', prenoms='$prenom', sexe='$sexe', codfil='$filiere'";
        if ($update_photo) {
            $req .= ", photo_identite='$image_name'";
        }
        $req .= " WHERE id = $id";

        if (mysqli_query($connexion, $req)) {
            header("location:index.php?edit=1");
            exit;
        } else {
            $erreur = "Erreur lors de la mise à jour dans la base de données.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un etudiant</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h4 class="mb-3 text-primary">Modifier l'etudiant</h4>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?php echo $erreur; ?></div>
    <?php endif; ?>

    <form action="modifier.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control"
                   value="<?php echo htmlspecialchars($pub['nom']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prenoms</label>
            <input type="text" name="prenom" class="form-control"
                   value="<?php echo htmlspecialchars($pub['prenoms']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Sexe</label>
            <select name="statut" class="form-select" required>
                <option value="Masculin"  <?php if($pub['sexe']=='Masculin') echo 'selected'; ?>>Masculin</option>
                <option value="Feminin"<?php if($pub['sexe']=='Feminin') echo 'selected'; ?>>Feminin</option>
                <option value="---"<?php if($pub['sexe']=='---') echo 'selected'; ?>>---</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Image actuelle</label><br>
            <?php
            $path = 'uploads/'.$pub['photo_identite'];
            if (!empty($pub['photo_identite']) && file_exists($path)) {
                echo '<img src="'.$path.'" style="width:120px;">';
            } else {
                echo 'Aucune image';
            }
            ?>
        </div>
        <div class="form-group">
                <label><i class="fas fa-list me-2"></i>Selectionner une filiere</label>
                <select class="form-select" name="filiere" required>
                    
                    
                        <?php foreach ($execution as $p): ?>
                        <option value="<?= $p['codfil'] ?>">
                            <?= htmlspecialchars($p['codfil']) ?>  
                        </option>
                        <?php endforeach; ?>
                   
                </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Remplacer l'image (facultatif)</label>
            <input type="file" name="image_etu" class="form-control">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>