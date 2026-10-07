<?php
include 'connexion.php';

if (isset($_POST['submit'])) {
    // Récupération et sécurisation des données
    $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
    $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
    $sexe = mysqli_real_escape_string($connexion, $_POST['sexe']);
    $filiere = mysqli_real_escape_string($connexion, $_POST['filiere']);
    
    // Gestion de l'upload de l'image
    $target_dir = "uploads/";
    $image_name = time() . "_" . basename($_FILES["image_etu"]["name"]);
    $target_file = $target_dir . $image_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Vérifier si l'image est une vraie image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image_etu"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            header("location: ajouter_ecole.php?error=1");
            exit();
        }
    }
    
    // Vérifier la taille du fichier (max 5Mo)
    if ($_FILES["image_etu"]["size"] > 5000000) {
        header("location: ajouter_ecole.php?error=2");
        exit();
    }
    
    // Autoriser certains formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        header("location: ajouter_ecole.php?error=3");
        exit();
    }
    
    // Upload du fichier
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image_etu"]["tmp_name"], $target_file)) {
            
            // Insertion dans la base de données avec le statut dynamique
            $requete = "INSERT INTO etudiant (nom,prenoms,sexe,photo_identite,codfil) 
                       VALUES ('$nom','$prenom','$sexe', '$image_name','$filiere')";
            
            $execution = mysqli_query($connexion, $requete);
            $req2 = "UPDATE filiere SET effectif = effectif + 1 WHERE codfil = '$filiere'";
            mysqli_query($connexion, $req2);
            

            if ($execution) {
                header("location: ajouter_ecole.php?success=1");
            } else {
                header("location: ajouter_ecole.php?error=4");
            }
        } else {
            header("location: ajouter_ecole.php?error=5");
        }
    }
} else {
    header("location: ajouter_ecole.php");
}
?>