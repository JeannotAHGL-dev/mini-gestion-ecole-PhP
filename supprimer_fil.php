<?php
include 'connexion.php';

// Récupération sécurisée de l'ID passé en paramètre GET
$id = (string) $_GET['codfil'];

if ($id > 0) {
    $requete = "DELETE FROM filiere WHERE codfil = '$id' ";
    $execution = mysqli_query($connexion, $requete);

    if ($execution) {
        header("location: index_fil.php?delete=1");
    } else {
        header("location: index_fil.php?error=1");
    }
} else {
    header("location: index_fil.php");
}
?>