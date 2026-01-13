<?php
    session_start();
?>
<div class="row">
    <div class="col-sm-9">
        <!--barre de recherche (include)-->
            <nav  class="navbar navbar-expand-sm navbar-dark bg-dark">
                <div class="container-fluid">
                    <img src="livre.jpg" alt="logo" width="100px" height="100px">
                    <a class="navbar-brand" href="javascript:void(0)"> <a href="accueil_admin.php">Biblio-Drive</a></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="mynavbar">
                    <form class="d-flex" action="lister_livre.php" method="get">
                        <input class="form-control me-2" type="text" placeholder="Recherche dans le catalogue (saisie du nom de l'auteur)" name="navbar">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
                    </form>
                    <button class="btn btn-dark" type="button"><a href="panier.php">Panier</a></button>
                    <button class="btn btn-primary" type="button"><a href="ajouter_livre.php">Ajouter un livre</a></button>
                    <button class="btn btn-primary" type="button"><a href="ajouter_membre.php">Ajouter un membre</a></button>
                    </div>
                </div>
                </nav>
    </div>
    <div class="col-sm-3">
            <!--image Moulinsart-->
            <img src="moulinsart1.jpg" alt="moulinsart" width="450px" height="280px">
    </div>
</div>
