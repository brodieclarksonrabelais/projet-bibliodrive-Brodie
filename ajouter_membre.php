<?php
/*if(password_hash($mdp,PASSWORD_DEFAULT))
commencer la verif de mdp le temps de créer les premiers utilisateurs */
        if (!isset($_POST['submit']))
{
?>
    <form action="ajouter_membre.php" method="post">
        Mel : <input type="text" name="mel" required><br>
        Mot de passe : <input type="text" name="mdp" required><br>
        Nom: <input type="text" name="nom" required><br>
        Prénom: <input type="text" name="prenom" required><br>
        Adresse: <input type="text" name="adresse" required><br>
        Code postal : <input type="text" name="code_postal" required><br>
        <input type="submit" value="Ajouter l'utilisateur" name="Créer">
    </form>
<?php
}
else 
{
    require_once('connexion.php');
    $mel = $_POST['mel'];
    $mdp = $_POST['mdp'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $code_postal = $_POST['code_postal'];

    $stmt = $connexion->prepare("INSERT INTO utilisateur (mel, mdp, nom, prenom, adresse, code_postal) VALUES (:mel, :mdp, :nom, :prenom, :adresse, :code_postal)");
    $stmt->bindParam(':mel', $mel, PDO::PARAM_STR);
    $stmt->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $stmt->bindParam(':code_postal', $code_postal, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<h3>Utilisateur ajouté avec succès!</h3>";
    } else {
        echo "<h3>Erreur lors de l'ajout de l'agent.</h3>";
    }
}
?>
