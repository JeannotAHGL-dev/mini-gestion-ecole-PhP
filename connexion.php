<?php
$hostname ="localhost";
$username ="root";
$password ="";
$database ="ecole";

$connexion = mysqli_connect($hostname, $username,$password, $database);


if (!$connexion){
    die("connexion echouee :" . mysqli_connect_error());
}
?>