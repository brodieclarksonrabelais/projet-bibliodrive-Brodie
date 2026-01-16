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
        if (isset($_SESSION['profil'])) {
            if ($_SESSION["profil"] == "admin") {
                include 'entete_admin.php';
            } else {
                include 'entete.php';
            }
        ?>
        <div class="row">
            <div class="col-sm-9">
                <?php
                if(!isset($_SESSION['panier'])){
                    // Initialisation du panier
                    $_SESSION['panier'] = array(); // regroupe les informations
                }
                ?>
                <h1 id='panier'class="couleur3">Votre panier :</h1>  
                <?php 
                    
                    // Affichage du panier 
                    $nb_livresempruntes = count($_SESSION['panier']); 
                    $nb_emprunts = (5 - $nb_livresempruntes);
                    echo '<h5 class="couleur1" id="reste">(Il vous reste ', $nb_emprunts ,' réservations possibles.)</h5>';
                    
                    for ($id =0 ;$id < $nb_livresempruntes; $id++){ // initialise et poursuit l'exécution pour compter le nombre de livre
                        $stmt = $connexion->prepare("SELECT titre, nom, prenom FROM livre l INNER JOIN auteur a ON (l.noauteur=a.noauteur) WHERE nolivre = :nolivre");
                        $stmt->bindValue(':nolivre', $_SESSION['panier'][$id], PDO::PARAM_INT);
                        $stmt->execute();
                        $livre = $stmt->fetch(PDO::FETCH_OBJ);

                        echo '<form method="POST">'; //transmet les information
                        echo '<p id="contenupanier">', $livre->titre . ', ' . $livre->prenom . ' ' . $livre->nom;
                        echo '<input type="submit" id="contenupanier" name="annuler" class="btn btn-danger"  value="suprimer du panier">';
                        echo '</form></p>';
                    } 
                    
                    if (empty($_SESSION['panier'])){ //verifie si la session est considérée comme vide
                        echo '<h5 class="couleur2" id="vide">Votre panier est vide</h5>';

                    } else { //affichage du panier quand il n'est pas vide
                        echo '<form method="POST">';
                        
                        foreach($_SESSION['panier'] as $nolivre) { // parcour tous les livres dans le tableau panier
                            echo '<input type="hidden" name="nolivre[]" value="'. $nolivre .'">';
                        }
                        echo '<input type="submit" name="valider" class="btn btn-success btn-lg" value="Valider le panier">';
                        echo '</form>';
                    }
            // bouton annuler
                        if(isset($_POST['annuler'])){  
                            unset($_SESSION['panier'][array_search($_SESSION['panier'][$id], $_SESSION['panier'])]);
                            sort($_SESSION['panier']); 
                            header("refresh: 0");
                        }
            // bouton valider
                    if(isset($_POST['valider'])){
                    require_once('connexion.php');
                    $mel = $_SESSION['mel'];
                    $dateemprunt = date("Y-m-d");
                
                    foreach($_SESSION['panier'] as $nolivre) { // parcour tous les livres dans le tableau le panier
                
                        echo "Tentative d'ajout du livre: $nolivre<br>";
                
                        // Requête pour ajouter les informations du livre dans la base de données SQL
                        try {
                            $stmt = $connexion->prepare("INSERT INTO emprunter(mel, nolivre, dateemprunt) VALUES (:mel, :nolivre, :dateemprunt)");
                            //Associe la meme valeur du nom de la requête SQL qui est utilisé pour la requête
                            $stmt->bindValue(':mel', $mel, PDO::PARAM_STR); 
                            $stmt->bindValue(':dateemprunt', $dateemprunt);
                            $stmt->bindValue(':nolivre', $nolivre, PDO::PARAM_INT);
                            $stmt->execute();
                            echo "Le livre $nolivre a été ajouté avec succès.<br>";
                        
                            } catch (PDOException $e) { 
                            echo "Erreur lors de l'ajout du livre $nolivre: " . $e->getMessage() . "<br>";
                        }
                    }
                
                    // Vider le panier après la validation
                    $_SESSION['panier'] = array();
                    header("refresh 0"); 
                    exit;
                }
        }else {
            include 'entete.php';
            echo "<h3>Erreur : vous devez être connecté pour accéder au panier</h3>";
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