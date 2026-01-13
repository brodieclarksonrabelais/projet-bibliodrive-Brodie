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
    <title>Ajouter un membre</title>
</head>
<body>
    <div class="container-fluid">
    <?php
    if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
        include 'entete_admin.php';
        if (!isset($_POST['submit'])) {
            ?>
            <div class="row">
		        <div class="col-sm-9">
                    <div class="card mt-4">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">Ajouter un nouveau membre</h4>
                        </div>
                        <div class="card-body">
                            <form action="ajouter_membre.php" method="post">
                                <div class="mb-3">
                                    <label for="mel" class="form-label">Email</label>
                                    <input type="email" name="mel" id="mel" class="form-control" placeholder="exemple@email.com" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="motdepasse" class="form-label">Mot de passe</label>
                                    <input type="password" name="motdepasse" id="motdepasse" class="form-control" minlength="6" required>
                                    <small class="form-text text-muted">Minimum 6 caractères</small>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" name="nom" id="nom" class="form-control" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="prenom" class="form-label">Prénom</label>
                                        <input type="text" name="prenom" id="prenom" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="adresse" class="form-label">Adresse</label>
                                    <input type="text" name="adresse" id="adresse" class="form-control" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="codepostal" class="form-label">Code postal</label>
                                    <input type="text" name="codepostal" id="codepostal" class="form-control" pattern="[0-9]{5}" title="Le code postal doit contenir 5 chiffres" required>
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-success">Ajouter l'utilisateur</button>
                                <a href="index.php" class="btn btn-secondary">Annuler</a>
                            </form>
                        </div>
                    </div>
                    <?php
                    }
                    else 
                    {
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
                            echo "<div class='alert alert-success mt-4' role='alert'>";
                            echo "<h4 class='alert-heading'>Succès!</h4>";
                            echo "<p>L'utilisateur <strong>" . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . "</strong> a été ajouté avec succès!</p>";
                            echo "<hr>";
                            echo "<p><strong>Email:</strong> " . htmlspecialchars($mel) . "</p>";
                            echo "<a href='ajouter_membre.php' class='btn btn-success'>Ajouter un autre membre</a> ";
                            echo "<a href='index.php' class='btn btn-secondary'>Retour à l'accueil</a>";
                            echo "</div>";
                        } else {
                            echo "<div class='alert alert-danger mt-4' role='alert'>";
                            echo "<h4 class='alert-heading'>Erreur!</h4>";
                            echo "<p>Une erreur est survenue lors de l'ajout de l'utilisateur.</p>";
                            echo "<a href='ajouter_membre.php' class='btn btn-success'>Réessayer</a>";
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