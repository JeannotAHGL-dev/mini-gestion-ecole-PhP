<?php
include 'connexion.php';

if (!isset($_GET['codfil'])) {
    header("location:index_fil.php");
    exit;
}

$codfil = (string) $_GET['codfil'];
$req = "SELECT * FROM filiere WHERE codfil = '$codfil'";
$res = mysqli_query($connexion, $req);
if (!$res || mysqli_num_rows($res) == 0) {
    header("location:index_fil.php");
    exit;
}

$pub = mysqli_fetch_assoc($res);
$erreur = '';

if (isset($_POST['submit'])) {
    $codfil = mysqli_real_escape_string($connexion, $_POST['codfil']);
    $libfil = mysqli_real_escape_string($connexion, $_POST['libfil']);
    $effectif  = mysqli_real_escape_string($connexion, $_POST['effectif']);

   
        $req = "UPDATE filiere SET codfil='$codfil', libfil='$libfil', effectif=$effectif";
        
        $req .= " WHERE codfil = $codfil";

        if (mysqli_query($connexion, $req)) {
            header("location:index_fil.php?edit=1");
            exit;
        } else {
            $erreur = "Erreur lors de la mise à jour dans la base de données.";
        }
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la filiere</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h4 class="mb-3 text-primary">Modifier la filiere</h4>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?php echo $erreur; ?></div>
    <?php endif; ?>

    <form action="modifier_fil.php?id=<?php echo $codfil; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Code</label>
            <input type="text" name="codfil" class="form-control"
                   value="<?php echo htmlspecialchars($pub['codfil']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Libellé</label>
            <input type="text" name="libfil" class="form-control"
                   value="<?php echo htmlspecialchars($pub['libfil']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Effectif</label>
            <input type="number" name="effectif" class="form-control"
                   value="<?php echo htmlspecialchars($pub['effectif']); ?>" >
        </div>

        

       

        

        <button type="submit" name="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index_fil.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>