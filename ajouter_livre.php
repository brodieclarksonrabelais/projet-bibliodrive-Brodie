<?php
session_start();
require_once 'connexion.php';
if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
    include 'entete_admin.php';
    if (!isset($_POST['submit'])){
        ?>
            <form action="ajouter_livre.php" method="post">
                <select name="activite" required>
                <?php
                $stmt = $connexion->prepare("SELECT nom, noauteur FROM auteur;");
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                // Les résultats retournés par la requête seront traités en 'mode' objet
                $stmt->execute();
                // Parcours des enregistrements retournés par la requête : premier, deuxième…
                while($enregistrement = $stmt->fetch())
                {
                    echo '<option value="', $enregistrement->noauteur,'">', $enregistrement->nom,'</option>';
                }
                ?>
                </select>
                Titre : <input type="text" name="titre" required><br>
                ISBN13 : <input type="text" name="isbn13" required><br>
                Année de parution : <input type="text" name="anneeparution" required><br>
                Résumé : <input type="text" name="detail" required><br>
                Image : <input type="text" name="photo" required><br>
                <input type="submit" value="Ajouter le livre" name="submit">
            </form>
        <?php
        }
        else 
        {
            require_once('connexion.php');
            $titre = $_POST['titre'];
            $isbn13 = $_POST['isbn13'];
            $anneeparution = $_POST['anneeparution'];
            $detail = $_POST['detail'];
            $photo = $_POST['photo'];

            $stmt = $connexion->prepare("INSERT INTO livre (titre, isbn13, anneeparution, detail, photo) VALUES (:titre, :isbn13, :anneeparution, :detail, :photo)");
            $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
            $stmt->bindParam(':isbn13', $isbn13, PDO::PARAM_STR);
            $stmt->bindParam(':anneeparution', $anneeparution, PDO::PARAM_STR);
            $stmt->bindParam(':detail', $detail, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "<h3>Livre ajouté avec succès!</h3>";
            } else {
                echo "<h3>Erreur lors de l'ajout du livre.</h3>";
            }
        }
    } else {
        include 'entete.php';
        echo "<h3>Erreur : vous n'avez pas les autorisation requises pour accéder à cette page.</h3>";
    }
?>
