<?php
include 'connexion.php';

// Récupération sécurisée de l'ID passé en paramètre GET
$id = (int) $_GET['id'];

if ($id > 0) {
    $requete = "DELETE FROM etudiant WHERE id = $id ";
    $execution = mysqli_query($connexion, $requete);

    if ($execution) {
        header("location: index.php?delete=1");
    } else {
        header("location: index.php?error=1");
    }
} else {
    header("location: index.php");
}
?>