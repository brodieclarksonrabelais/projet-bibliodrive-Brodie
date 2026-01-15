<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bibliodrive.css">
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

                $stmt = $connexion->prepare("SELECT * FROM livre l INNER JOIN auteur a ON (l.noauteur = a.noauteur) WHERE l.nolivre = :nolivre");
                $nolivre = $_GET["nolivre"];
                $stmt->bindValue(":nolivre", $nolivre);
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
                    
                    $nb_livresmax = 5;
                    $nb_livresempruntes = count($_SESSION['panier']); 
                    $_SESSION['nb_livresempruntes'] = $nb_livresempruntes;

                    if (isset($_SESSION["prenom"]))//vérifie la variable 
                        {
                            if ($_SESSION['nb_livresempruntes'] < $nb_livresmax)
                                {
                                    echo '<form method="POST">';
                                    echo '<input type="submit" name="btn-ajoutpanier" class="btn btn-success btn-lg" value="Ajouter au panier"></input>';
                                    echo '</form>';
                                } else {
                                    echo '<h5>Il y a trop de livre dans le panier (Max 5 livres)</h5>';
                                }
                        }else{
                            echo '<p class="text-primary">Pour pouvoir réserver ce livre vous devez posséder un compte et vous identifier !</p>';
                        }

                        if(!isset($_SESSION['panier'])){//vérifie que la variable existe

                        $_SESSION['panier'] = array(); //stocke plusieurs valeurs dans une seule variable
                        }

                        // On ajoute les entrées dans le tableau
                        if(isset($_POST['btn-ajoutpanier'])){//vérifie la variable 
                            array_push($_SESSION['panier'], $enregistrement->nolivre);//insère plusieurs éléments à la fin d'un tableau.
                            echo "Livre ajouté à votre panier avec succès !";
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