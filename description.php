<?php
    include 'entete.php';
    require_once('connexion.php');

    $stmt=$connexion->prepare("SELECT * from emprunter where nolivre");
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    $enregistrement2 = $stmt->fetch();

    
    $reponse = $_GET["idlivre"];
    $stmt=$connexion->prepare("SELECT * from livre l inner join auteur a on (l.noauteur = a.noauteur) where l.nolivre=:pnumero");
    $stmt->bindValue(":pnumero", $reponse);
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();
    $enregistrement = $stmt->fetch();


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

    if (isset($_SESSION['mail'])){

        if ($enregistrement->nolivre == $enregistrement2->nolivre){
            echo '<h5 style="color:red;"> Livre déjà emprunté </h5>';
        } else {
            echo '<h5 style="color:green;"> Livre disponible </h5>';
        }
        echo
        '<form method="get" action="detail_livre.php">',
            //'<input type="hidden" name="idlivre" value="' . $enregistrement->nolivre . '"/>',
            '<button type="submit" name="ajoutpanier" value="' . $enregistrement->nolivre . '" class="btn btn-outline-info">Ajouter au panier</button>',
        '</form>';
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
    echo
        '</div>',
        '<div class="col-sm-6">',
            '<img src="images-couvertures/covers/' . $enregistrement->photo . '" alt="' . $enregistrement->photo . '" height="' . 400 . '">',
        '</div>';
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