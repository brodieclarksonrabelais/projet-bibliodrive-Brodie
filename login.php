  <div class="container col-mt-3">

  <?php

  /* si la session est occuper, alors tu affiches les info, sinon, si le bouton connecter n'est pas cliqué tu affiches les cases pour remplir ta session, 
  sinon tu fais ta requete, tu recup les infos (si le profil est admin redirection sur menu admin, sinon redirection sur ce meme programme (header location : login.php))
  */

    if (!isset($_SESSION["mel"])) { 
      if (!isset($_POST['btnconnexion'])) { 
        echo '
      <form id="div_color" action="" method="post">
        <div class="mb-3 mt-3">
          <h2>Se connecter</h2>
          <label for="identifiant">Identifiant:</label>
          <input type="text" class="form-control" id="identifiant" placeholder="Entrer votre identifiant" name="mel">
        </div>
        <div class="mb-3">
          <label for="motdepasse">Mot de passe:</label>
          <input type="password" class="form-control" id="mdp" placeholder="Entrer votre Mot de passe" name="motdepasse">
        </div>
        <button type="submit" class="btn btn-primary" name ="btnconnexion">connexion</button>
      </form>';

      } else {
          require_once 'connexion.php';
          $mel = $_POST['mel']; 
          $motdepasse = $_POST['motdepasse'];

          $stmt = $connexion->prepare("SELECT * FROM utilisateur WHERE mel=:mel AND motdepasse=:motdepasse");
          $stmt->bindValue(":mel", $mel); 
          $stmt->bindValue(":motdepasse", $motdepasse); 
          $stmt->setFetchMode(PDO::FETCH_OBJ);
          $stmt->execute();
          $enregistrement = $stmt->fetch(); 

          if ($enregistrement) { 
              $_SESSION["mel"] = $mel;
              $_SESSION["prenom"] = $enregistrement->prenom;
              $_SESSION["nom"] = $enregistrement->nom;
              $_SESSION["adresse"] = $enregistrement->adresse;
              $_SESSION["codepostal"] = $enregistrement->codepostal;
              $_SESSION["ville"] = $enregistrement->ville;
              $_SESSION["profil"] = $enregistrement->profil;


              if ($_SESSION["profil"] == "admin") {
                  header("Location: accueil_admin.php"); 
              } else {
                header("Location: index.php"); 
              }
              exit();
          } else { 
              echo "Echec de la connexion.";
              exit();
        }      
      }
    } else {
      
        echo $_SESSION["prenom"] . ' ' . $_SESSION["nom"]. '<br/>';
        echo $_SESSION["mel"] .'<br/>'; 
        echo $_SESSION["adresse"]. ' ' . $_SESSION["codepostal"] .'<br/>'; 
      
        if (!isset($_POST['deco'])) { 
          echo '<form method="post">
          <div class="input-group-btn text-center">
              <button class="btn btn-danger" name="deco" type="submit">Déconnexion</button>
          </div>
      </form>';
        } else {
          session_unset();         
          session_destroy();
          header("Location: index.php");
          exit();
      }
    }

  ob_end_flush();
  ?>
  </div>
</div>
