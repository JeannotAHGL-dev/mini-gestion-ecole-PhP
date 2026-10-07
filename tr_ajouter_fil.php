<?php
include 'connexion.php';

if (isset($_POST['submit'])) {
    // Récupération et sécurisation des données
    $code = mysqli_real_escape_string($connexion, $_POST['code']);
    $lib = mysqli_real_escape_string($connexion, $_POST['lib']);
    $effectif = mysqli_real_escape_string($connexion, $_POST['effectif']);
    
    
            
            // Insertion dans la base de données avec le statut dynamique
            $requete = "INSERT INTO filiere (codfil,libfil,effectif) 
                       VALUES ('$code','$lib','$effectif')";
            
            $execution = mysqli_query($connexion, $requete);
            
            if ($execution) {
                header("location: ajouter_filiere.php?success=1");
            } else {
                header("location: ajouter_filiere.php?error=4");
            }
        } else {
            header("location: ajouter_filiere.php?error=5");
        }


?>