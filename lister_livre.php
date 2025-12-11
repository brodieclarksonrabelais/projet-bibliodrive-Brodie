<?php
    require_once('connexion.php');
    $stmt = $connexion->prepare("SELECT titre, anneeparution FROM livre INNER JOIN auteur ON (livre.noauteur = auteur.noauteur) WHERE autheur.nom LIKE :navbar");
    $stmt->bindValue(":navbar", "%".$_GET['navbar']."%");
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    while($enregistrement = $stmt->fetch())
    {
    echo '<p>', $enregistrement->titre, ' ', $enregistrement->anneeparution,' ','</p>';
    }
?>