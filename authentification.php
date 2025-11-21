<!DOCTYPE html>
<html lang="en">
<head>
  <title>Authentification</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Se connecter</h2>
  <?php
  if (!isset($_POST['btnSeConnecter'])) { 
    echo '
  <form action="/action_page.php">
    <div class="mb-3 mt-3">
      <label for="identifiant">Identifiant:</label>
      <input type="text" class="form-control" id="identifiant" placeholder="Entrer votre identifiant" name="identifiant">
    </div>
    <div class="mb-3">
      <label for="mdp">Mot de passe:</label>
      <input type="password" class="form-control" id="mdp" placeholder="Entrer votre Mot de passe" name="mdp">
    </div>
    <button type="submit" class="btn btn-primary">connexion</button>
  </form>';
} else

{

    require_once 'connexion.php';
    $identifiant = $_POST['identifiant'];
    $mdp = $_POST['mdp'];
    $stmt = $connexion->prepare("SELECT * FROM agent where identifiant=:identifiant AND mdp=:mdp");
    $stmt->bindValue(":identifiant", $identifiant); 
    $stmt->bindValue(":mdp", $mdp); 
    $stmt->setFetchMode(PDO::FETCH_OBJ);

    $stmt->execute();
    $enregistrement = $stmt->fetch(); 
    if ($enregistrement) { 
        echo '<h1>Connexion réussie !</h1>';
    } else { 
        echo "Echec à la connexion.";
    }
}
?>
</div>

</body>
</html>