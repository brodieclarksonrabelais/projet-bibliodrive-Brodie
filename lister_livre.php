<?php
    include 'entete.php';
    require_once('connexion.php');
    $stmt = $connexion->prepare("SELECT * FROM livre INNER JOIN auteur ON (livre.noauteur = auteur.noauteur) WHERE auteur.nom = :navbar");
    $stmt->bindValue(":navbar", $_GET['navbar']);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    while($enregistrement = $stmt->fetch())
    {
    echo '<a href="description.php?nolivre='. $enregistrement->nolivre,'"> ', $enregistrement->titre, ' ', $enregistrement->anneeparution,'</a><br/>';
    }
?>