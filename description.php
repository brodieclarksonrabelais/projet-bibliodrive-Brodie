<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <?php
            session_start();
            require_once 'connexion.php';
            if (isset($_SESSION['profil']) && $_SESSION["profil"] === "admin") {
                include 'entete_admin.php';
            } else {
                include 'entete.php';
        ?>
        <div class="row">
            <div class="col-sm-9">
                <?php
                    $stmt = $connexion->prepare("SELECT prenom, nom, isbn13, titre, anneeparution, detail, photo FROM livre l INNER JOIN auteur a ON (l.noauteur = a.noauteur) WHERE l.nolivre = :nolivre");
                    $stmt->bindValue(":nolivre", $_GET['nolivre']);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $stmt->execute();
                    while($enregistrement = $stmt->fetch())
                    {
                    echo "<img src= 'covers/". $enregistrement->photo ."'class='d-block w-100' alt='livre' height=400px width=300px>";
                    echo '<p>Auteur :', $enregistrement->prenom, ' ', $enregistrement->nom, ' ','</p>';
                    echo '<p>ISBN13 :', $enregistrement->isbn13,' ','</p>';
                    echo  '<p>Résumé de : ', $enregistrement->titre,' ','<br/>', $enregistrement->detail,' ','</p>';
                    echo '<p>Date de parution :', $enregistrement->anneeparution,' ','</p>';
                    }
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