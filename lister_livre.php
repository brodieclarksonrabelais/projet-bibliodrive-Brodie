<?php
        require_once('connexion.php');
        $stmt = $connexion->prepare("SELECT titre, anneeparution FROM livre WHERE autheur = '';");
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();
        while($enregistrement = $stmt->fetch())
        {
        echo '<h3>', $enregistrement->titre, ' ', $enregistrement->anneeparution,' ','</h3>';
        }
    ?>