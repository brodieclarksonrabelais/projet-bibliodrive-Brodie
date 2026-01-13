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
        require_once('connexion.php');
        if (isset($_SESSION['profil']) && $_SESSION["profil"] == "admin") {
            include 'entete_admin.php';
            } else {
                    include 'entete.php';
                }
        ?>
        <div class="row">
            <div class="col-sm-9">
                <?php
                $stmt=$connexion->prepare("SELECT * from emprunter where nolivre");
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $stmt->execute();
                $enregistrement2 = $stmt->fetch();

                $stmt = $connexion->prepare("SELECT * FROM livre l INNER JOIN auteur a ON (l.noauteur = a.noauteur) WHERE l.nolivre = :nolivre");
                $stmt->bindValue(":nolivre", $_GET['nolivre']);
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $stmt->execute();
                while($enregistrement = $stmt->fetch())
                {
                echo '<div class="col-md-3".>';
                echo "<img src= 'covers/". $enregistrement->photo ."'class='d-block w-100' alt='livre' style='width=60%'>";
                echo'</div>';
                echo '<div class="col-md-4".>';
                echo '<p>Auteur :', $enregistrement->prenom, ' ', $enregistrement->nom, ' ','</p>';
                echo '<p>ISBN13 :', $enregistrement->isbn13,' ','</p>';
                echo  '<p>Résumé de : ', $enregistrement->titre,' ','<br/>', $enregistrement->detail,' ','</p>';
                echo '<p>Date de parution :', $enregistrement->anneeparution,' ','</p>';
                echo'</div>';
                                if (isset($_SESSION['mel'])){

                    if ($enregistrement->nolivre == $enregistrement2->nolivre){
                        echo '<h5 style="color:red;"> Livre déjà emprunté </h5>';
                    } else {
                        echo '<h5 style="color:green;"> Livre disponible </h5>';
                    echo
                    '<form method="get" action="detail_livre.php">',
                        '<button type="submit" name="ajoutpanier" value="' . $enregistrement->nolivre . '" class="btn btn-outline-info">Ajouter au panier</button>',
                    '</form>';
                    }
                    if (isset($_GET['ajoutpanier'])) {
                        $book_id = $_GET['ajoutpanier'];
                        if (!isset($_SESSION['panier'])) {
                            $_SESSION['panier'] = array();
                        }
                        if (!in_array($book_id, $_SESSION['panier'])) {
                            $_SESSION['panier'][] = $book_id;
                        }
                        header('Location: panier.php');
                        exit();
                    }
                }
                else{
                    echo '<h5 class="text-danger"> Veuillez vous connecter pour ajouter au panier </h5>';
                }

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