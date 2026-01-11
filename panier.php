<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
    <title>Bibliothèque</title>
</head>
<body>
    <div class="container-fluid">
        <?php
            require('entete.php');
        ?>
		<div class="row" id="top">
			<div class="col-sm-9">
				<?php
                    require_once('connexion.php');

                    if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
                        $id = $_GET['id'];
                        if (isset($_SESSION['panier'])) {
                            $key = array_search($id, $_SESSION['panier']);
                            if ($key !== false) {
                                unset($_SESSION['panier'][$key]);
                                $_SESSION['panier'] = array_values($_SESSION['panier']);
                            }
                        }
                        header('Location: panier.php');
                        exit();
                    }

                    $panier = array();

                    if (isset($_SESSION['panier'])) {
                        $panier = $_SESSION['panier'];
                    }

                    if (!empty($panier)) {
                        echo '<h3>Votre panier :</h3>';
                        foreach ($panier as $book_id) {
                            $stmt = $connexion->prepare("SELECT titre, photo FROM livre WHERE nolivre = ?");
                            $stmt->execute([$book_id]);
                            $book = $stmt->fetch(PDO::FETCH_OBJ);
                            echo '<div class="row mb-3">',
                            '<div class="col-sm-3"><img src="images-couvertures/covers/' . $book->photo . '" height="100" alt="' . $book->titre . '"></div>',
                            '<div class="col-sm-6"><h5>' . $book->titre . '</h5></div>',
                            '<div class="col-sm-3">',
                            '<form method="get" action="panier.php" style="display:inline;">',
                            '<input type="hidden" name="action" value="remove">',
                            '<input type="hidden" name="id" value="' . $book_id . '">',
                            '<button type="submit" class="btn btn-danger">Retirer</button>',
                            '</form>',
                            '</div>',
                            '</div>';
                        }
                    } else {
                        echo '<h3>Votre panier est vide.</h3>';
                    }
                    
                    if (!empty($panier)) {
                        echo '<form method="post" action="panier.php">';
                        echo '<button type="submit" name="valider" class="btn btn-success">Valider panier</button>';
                        echo '</form>';
                    }
                    
                    if (isset($_POST['valider'])) {
                        if (isset($_SESSION['mail']) && isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
                            $mail = $_SESSION['mail'];
                            $date = date('Y-m-d');
                            foreach ($_SESSION['panier'] as $book_id) {
                                $stmt = $connexion->prepare("INSERT INTO emprunter (mel, nolivre, dateemprunt) VALUES (?, ?, ?)");
                                $stmt->execute([$mail, $book_id, $date]);
                            }
                            unset($_SESSION['panier']);
                        }
                        header('Location: panier.php');
                        exit();
                    }
                ?>
            </div>
			<div class="col-sm-3">
				<?php
					require_once('formulaire.php');
				?>
			</div>
		</div>
	</div>
</body>
</html>