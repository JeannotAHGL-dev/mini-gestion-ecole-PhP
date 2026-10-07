<?php
include "connexion.php";

// Vérifier si l'ID est présent et valide
if (isset($_GET['id_publication']) && !empty($_GET['id_publication'])) {
    $id_publication = (int) $_GET['id_publication'];
    
    // Incrémenter le nombre de likes
    $requete = "UPDATE publications SET nbr_j_aime = nbr_j_aime + 1 WHERE id_publication = $id_publication";
    $execution = mysqli_query($connexion, $requete);
    
    if ($execution) {
        // Rediriger vers la page d'accueil avec un message de succès
        header("location: index copy.php?like=success");
    } else {
        header("location: index copy.php?like=error");
    }
} else {
    header("location: index copy.php");
}
exit();
?>