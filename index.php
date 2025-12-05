<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Accueil</title>
</head>
<body>
    <html>
	<head>
	</head>
	<body>
	<div class="container-fluid">
		<?php include 'entete.php';?>
		<div class="row">
		   <div class="col-sm-9">
					Dernières acquisitions
                    <div id="demo" class="carousel slide d-block w-25"  data-bs-ride="carousel" >		
					<!-- Indicators/dots -->
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
						<button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
						<button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
					</div>
					<!-- The slideshow/carousel -->
					
						<?php
								require_once('connexion.php');
								$stmt = $connexion->prepare("SELECT * FROM livre ORDER BY dateajout DESC LIMIT 3");
								$stmt->setFetchMode(PDO::FETCH_OBJ);
								$stmt->execute();
								echo "<div class='carousel-inner'>";
								while($enregistrement = $stmt->fetch()) {
									echo "<div class='carousel-item active'>";
									echo "<img src= 'covers/". $enregistrement->photo ."'class='d-block w-100' alt='livre'>";
									echo"</div>";
								}
						?>
							<button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
								<span class="carousel-control-prev-icon"></span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
								<span class="carousel-control-next-icon"></span>
							</button>
						</div>
					</div>
					<!-- Left and right controls/icons -->
			</div>
			<div class="col-sm-3">
					<!--formulaire de connexion / profil connecté (include)-->
					<?php include 'authentification.php';?>
			</div>
		</div>
	</div>
	</body>
</html>
</body>
</html>