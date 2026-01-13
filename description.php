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
    <title>Description du livre</title>
</head>
<body>
    <div class="container-fluid">
        <?php
            if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
                include 'entete_admin.php';
            } else {
                include 'entete.php';
            }
        ?>
        <div class="row">
            <div class="col-sm-9">
                <?php
                    $stmt = $connexion->prepare("SELECT prenom, nom, isbn13, titre, anneeparution, detail, photo FROM livre l INNER JOIN auteur a ON (l.noauteur = a.noauteur) WHERE l.nolivre = :nolivre");
                    $stmt->bindValue(":nolivre", $_GET['nolivre']);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $stmt->execute();
                    
                    if($enregistrement = $stmt->fetch())
                    {
                        echo "<div class='row mt-4'>";
                        echo "  <div class='col-md-4'>";
                        echo "    <img src='covers/" . htmlspecialchars($enregistrement->photo) . "' class='img-fluid rounded shadow' alt='Couverture du livre'>";
                        echo "  </div>";
                        echo "  <div class='col-md-8'>";
                        echo "    <h2>" . htmlspecialchars($enregistrement->titre) . "</h2>";
                        echo "    <p><strong>Auteur :</strong> " . htmlspecialchars($enregistrement->prenom) . " " . htmlspecialchars($enregistrement->nom) . "</p>";
                        echo "    <p><strong>ISBN13 :</strong> " . htmlspecialchars($enregistrement->isbn13) . "</p>";
                        echo "    <p><strong>Date de parution :</strong> " . htmlspecialchars($enregistrement->anneeparution) . "</p>";
                        echo "    <div class='mt-3'>";
                        echo "      <h4>Résumé</h4>";
                        echo "      <p>" . nl2br(htmlspecialchars($enregistrement->detail)) . "</p>";
                        echo "    </div>";
                        echo "  </div>";
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