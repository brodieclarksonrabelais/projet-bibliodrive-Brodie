<?php
    session_start();
    require_once 'connexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bibliodrive.css">
    <title>Accueil</title>
</head>
<body>
    <html>
	<head>
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
                    require_once('connexion.php');
                    $stmt = $connexion->prepare("SELECT * FROM livre INNER JOIN auteur ON (livre.noauteur = auteur.noauteur) WHERE auteur.nom = :navbar");
                    $stmt->bindValue(":navbar", $_GET['navbar']);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $stmt->execute();
                    while($enregistrement = $stmt->fetch())
                    {
                    echo '<a href="description.php?nolivre='. $enregistrement->nolivre,'"> ', $enregistrement->titre, ' ','(', $enregistrement->anneeparution,')','</a><br/>';
                    }
            ?>
            </div>
			<div class="col-sm-3">
					<!--formulaire de connexion / profil connecté (include)-->
					<?php include 'login.php';?>
			</div>
		</div>
	</div>
	</body>
</html>