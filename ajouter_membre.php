<?php
session_start();
/*if(password_hash($mdp,PASSWORD_DEFAULT))
commencer la verif de mdp le temps de créer les premiers utilisateurs */
require_once 'connexion.php';
if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
    include 'entete_admin.php';
    if (!isset($_POST['submit'])) {
        ?>
        <form action="ajouter_membre.php" method="post">
            Mel : <input type="text" name="mel" required><br>
            Mot de passe : <input type="text" name="motdepasse" required><br>
            Nom: <input type="text" name="nom" required><br>
            Prénom: <input type="text" name="prenom" required><br>
            Adresse: <input type="text" name="adresse" required><br>
            Code postal : <input type="text" name="codepostal" required><br>
            <input type="submit" value="Ajouter utilisateur" name="submit">
        </form>
        <?php
        }
        else 
        {
            require_once('connexion.php');
            $mel = $_POST['mel'];
            $motdepasse = $_POST['motdepasse'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $adresse = $_POST['adresse'];
            $codepostal = $_POST['codepostal'];
            $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT);

            $stmt = $connexion->prepare("INSERT INTO utilisateur (mel, motdepasse, nom, prenom, adresse, codepostal) VALUES (:mel, :motdepasse, :nom, :prenom, :adresse, :codepostal)");
            $stmt->bindParam(':mel', $mel, PDO::PARAM_STR);
            $stmt->bindParam(':motdepasse', $motdepasse, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':codepostal', $codepostal, PDO::PARAM_INT);


            if ($stmt->execute()) {
                echo "<h3>Utilisateur ajouté avec succès!</h3>";
            } else {
                echo "<h3>Erreur lors de l'ajout de l'agent.</h3>";
            }
        }
    } else {
        include 'entete.php';
        echo "<h3>Erreur : vous n'avez pas les autorisation requises pour accéder à cette page.</h3>";
    }    
?>
