<?php
    session_start();
    require_once 'connexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Ajouter un livre</title>
</head>
<body>
    <div class="container-fluid">
    <?php
    if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
        include 'entete_admin.php';
        if (!isset($_POST['submit'])){
            ?>
            <div class="row">
		        <div class="col-sm-9">
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Ajouter un nouveau livre</h4>
                        </div>
                        <div class="card-body">
                            <form action="ajouter_livre.php" method="post">
                                <div class="mb-3">
                                    <label for="auteur" class="form-label">Auteur</label>
                                    <select name="auteur" id="auteur" class="form-select" required>
                                        <option value="">Sélectionnez un auteur</option>
                                        <?php
                                        $stmt = $connexion->prepare("SELECT noauteur, nom, prenom FROM auteur ORDER BY nom, prenom"); 
                                        $stmt->execute();
                                        $auteurs = $stmt->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($auteurs as $auteur) { 
                                            echo "<option value='{$auteur->noauteur}'>{$auteur->prenom} {$auteur->nom}</option>"; 
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text" name="titre" id="titre" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="isbn13" class="form-label">ISBN13</label>
                                    <input type="text" name="isbn13" id="isbn13" class="form-control" pattern="[0-9]{13}" title="L'ISBN13 doit contenir 13 chiffres" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="anneeparution" class="form-label">Année de parution</label>
                                    <input type="number" name="anneeparution" id="anneeparution" class="form-control" min="1000" max="2099" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="detail" class="form-label">Résumé</label>
                                    <textarea name="detail" id="detail" class="form-control" rows="5" required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Nom du fichier image</label>
                                    <input type="text" name="photo" id="photo" class="form-control" placeholder="exemple: livre.jpg" required>
                                    <small class="form-text text-muted">Nom du fichier de couverture (doit être dans le dossier covers/)</small>
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-primary">Ajouter le livre</button>
                                <a href="index.php" class="btn btn-secondary">Annuler</a>
                            </form>
                        </div>
                    </div>
                    <?php
                        }
                        else 
                        {
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
                                echo "<div class='alert alert-success mt-4' role='alert'>";
                                echo "<h4 class='alert-heading'>Succès!</h4>";
                                echo "<p>Le livre <strong>" . htmlspecialchars($titre) . "</strong> a été ajouté avec succès!</p>";
                                echo "<hr>";
                                echo "<a href='ajouter_livre.php' class='btn btn-primary'>Ajouter un autre livre</a> ";
                                echo "<a href='index.php' class='btn btn-secondary'>Retour à l'accueil</a>";
                                echo "</div>";
                            } else {
                                echo "<div class='alert alert-danger mt-4' role='alert'>";
                                echo "<h4 class='alert-heading'>Erreur!</h4>";
                                echo "<p>Une erreur est survenue lors de l'ajout du livre.</p>";
                                echo "<a href='ajouter_livre.php' class='btn btn-primary'>Réessayer</a>";
                                echo "</div>";
                            }
                        }
                    } else {
                        include 'entete.php';
                        echo "<div class='alert alert-danger mt-4' role='alert'>";
                        echo "<h4 class='alert-heading'>Accès refusé</h4>";
                        echo "<p>Vous n'avez pas les autorisations requises pour accéder à cette page.</p>";
                        echo "<a href='index.php' class='btn btn-primary'>Retour à l'accueil</a>";
                        echo "</div>";
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