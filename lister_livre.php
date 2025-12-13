<?php
    require_once('connexion.php');
    $stmt = $connexion->prepare("SELECT titre, anneeparution FROM livre INNER JOIN auteur ON (livre.noauteur = auteur.noauteur) WHERE autheur.nom LIKE :navbar");
    $stmt=$connexion->prepare("SELECT * from livre l inner join auteur a on (l.noauteur = a.noauteur) where a.nom like :aut");
    $stmt->bindValue(':navbar', '%' . $_POST['navbar'] . '%', PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $nblignes = $stmt->execute();
    while($enregistrement = $stmt->fetch()){
        echo '<a href="http://localhost/projet-bibliodrive-Brodie/description.php">suite</a><br>';
    }
?>