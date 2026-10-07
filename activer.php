<?php
include 'connexion.php';

$id = isset($_GET['id_publication']) ? (int)$_GET['id_publication'] : 0;
if ($id > 0) {
    $sel = "SELECT statut FROM publications WHERE id_publication = $id";
    $res = mysqli_query($connexion, $sel);
    if ($res && mysqli_num_rows($res) > 0) {
        $row     = mysqli_fetch_assoc($res);
        $courant = $row['statut'];
        $nouveau = ($courant === 'Actif') ? 'Inactif' : 'Actif';
        mysqli_query($connexion, "UPDATE publications SET statut='$nouveau' WHERE id_publication = $id");
    }
}

header("location:index.php");
exit;