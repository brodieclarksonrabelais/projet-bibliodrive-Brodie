<?php
    require_once('connexion.php');
    $recherche = $_GET['recherche'] ;
    $stmt = $connexion->prepare("SELECT titre, anneeparution FROM livre INNER JOIN auteur ON (livre.noauteur = auteur.noauteur) WHERE  :nomAuteur = $recherche ;");
    $stmt->bindValue(":nomAuteur", $recherche);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    while($enregistrement = $stmt->fetch())
    {
    echo '<h3>', $enregistrement->titre, ' ', $enregistrement->anneeparution,' ','</h3>';
    }
?>