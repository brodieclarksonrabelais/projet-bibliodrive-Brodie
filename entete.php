<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>entete</title>
</head>
<body>
    <div class="row">
        <div class="col-sm-9">
            <!--barre de recherche (include)-->
            
                <nav action="lister_livre.php" class="navbar navbar-expand-sm navbar-dark bg-dark" method="get">
                    <div class="container-fluid">
                        <img src="livre.jpg" alt="logo" width="100px" height="100px">
                        <a class="navbar-brand" href="javascript:void(0)"> Biblio-Drive</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="mynavbar">
                        <form class="d-flex">
                            <input class="form-control me-2" type="text" placeholder="Recherche dans le catalogue (saisie du nom de l'auteur)" name="recherche">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a href="lister_livre.php">Rechercher</a></button>
                            <php? $recherche = $_GET['recherche'] ; ?>
                        </form>
                        <button class="btn btn-primary" type="button"><a href="panier.php">Panier</a></button>

                        </div>
                    </div>
                    </nav>
        </div>
        <div class="col-sm-3">
                <!--image Moulinsart-->
                <img src="moulinsart.jpg" alt="moulinsart" width="400px" height="300px">
        </div>
	</div>
</body>
</html>