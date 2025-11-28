<?php
        if (!isset($_POST['submit']))
{
?>
    <form action="ajouter_livre.php" method="post">
        Titre : <input type="text" name="titre" required><br>
        ISBN13 : <input type="text" name="ISBN13" required><br>
        Année de parution : <input type="text" name="anneeparution" required><br>
        Résumé : <input type="text" name="summary" required><br>
        Image : <input type="text" name="cover" required><br>
        <input type="submit" value="Ajouter le livre" name="Ajouter">
    </form>
<?php
}
else 
{
    require_once('connexion.php');
    $titre = $_POST['titre'];
    $ISBN13 = $_POST['ISBN13'];
    $anneeparution = $_POST['anneeparution'];
    $resume = $_POST['summary'];
    $cover = $_POST['cover'];

    $stmt = $connexion->prepare("INSERT INTO utilisateur (titre, ISBN13, anneeparution, summary, cover) VALUES (:titre, :ISBN13, :anneeparution, :summary, :cover)");
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':ISBN13', $ISBN13, PDO::PARAM_STR);
    $stmt->bindParam(':anneeparution', $anneeparution, PDO::PARAM_STR);
    $stmt->bindParam(':summary', $summary, PDO::PARAM_STR);
    $stmt->bindParam(':cover', $cover, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<h3>Utilisateur ajouté avec succès!</h3>";
    } else {
        echo "<h3>Erreur lors de l'ajout de l'agent.</h3>";
    }
}
?>
