<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>

</head>
<body>
    <div class="container-fluid">
    <?php
    session_start();
    require_once 'connexion.php';
    if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
        include 'entete_admin.php';
        if (!isset($_POST['submit'])){
    ?>
            <div class="row">
		        <div class="col-sm-9">
                    <form action="ajouter_livre.php" method="post">
                        <select name="auteur" required>
                        <?php
                        $stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur"); 
                        $stmt->execute();
                        $auteurs = $stmt->fetchAll(PDO::FETCH_OBJ);
                        foreach ($auteurs as $auteur) { 
                            echo "<option value='{$auteur->noauteur}'>{$auteur->prenom} {$auteur->nom}</option>"; 
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
                            $noauteur = $_POST['auteur'];
                            $titre = $_POST['titre'];
                            $isbn13 = $_POST['isbn13'];
                            $anneeparution = $_POST['anneeparution'];
                            $detail = $_POST['detail'];
                            $photo = $_POST['photo'];
                            $dateajout = date('Y-m-d H:i:s');

                            $stmt = $connexion->prepare("INSERT INTO livre (noauteur, titre, isbn13, anneeparution, detail, photo, dateajout) VALUES (:noauteur, :titre, :isbn13, :anneeparution, :detail, :photo, :dateajout)");
                            $stmt->bindParam(':noauteur', $noauteur, PDO::PARAM_INT);
                            $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
                            $stmt->bindParam(':isbn13', $isbn13, PDO::PARAM_STR);
                            $stmt->bindParam(':anneeparution', $anneeparution, PDO::PARAM_STR);
                            $stmt->bindParam(':detail', $detail, PDO::PARAM_STR);
                            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
                            $stmt->bindParam(':dateajout', $dateajout);

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
                </div>
                <div class="col-sm-3">
                    <?php include 'login.php';?>
                </div>
            </div>
    </div>
</body>
</html>