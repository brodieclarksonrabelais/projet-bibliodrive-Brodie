<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>entete</title>
</head>
<body>
    <div class="row">
        <div class="col-sm-9">
            <!--barre de recherche (include)-->
                <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                    <div class="container-fluid">
                        <img src="livre.jpg" alt="logo" width="100px" height="100px">
                        <a class="navbar-brand" href="javascript:void(0)"> Biblio-Drive</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="mynavbar">
                        <form class="d-flex">
                            <input class="form-control me-2" type="text" placeholder="Recherche dans le catalogue (saisie du nom de l'auteur)">
                            <button class="btn btn-primary" type="button">Rechercher</button>
                        </form>
                        <button class="btn btn-primary" type="button"><a href="panier.php">Panier</a></button>

                        </div>
                    </div>
                    </nav>
        </div>
        <div class="col-sm-3">
                <!--image Moulinsart-->
                <img src="moulinsart.jpg" alt="moulinsart" width="500px" height="300px">
        </div>
	</div>
</body>
</html>