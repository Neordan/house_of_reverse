<?php
require "./core/header.php";


//session de la session pour la création de compte
$_SESSION['message'] = "Ton compte a bien été créé !";


$role = "utilisateur";

// Vérifie si le formulaire a été envoyé
if (!empty($_POST)) {

    // Vérifie que tous les champs du formulaire sont remplis

    // Vérifie que les mots de passe sont identiques
    if ($_POST["hash_mdp1"] == $_POST["hash_mdp2"]) {

        // Initialise les variables
        $email = trim($_POST["email"]);
        $nom = trim($_POST["nom"]);
        $prenom = trim($_POST["prenom"]);
        $age = $_POST["age"];
        $allergie = (isset($_POST["allergies"]) && is_array($_POST["allergies"])) ? implode(',', $_POST["allergies"]) : '';
        if ($_POST["ongles_ronges"] == 'non') {
            $ongles = 0;
        } else {
            $ongles = 1;
        }

        // Vérifie que l'âge entré est valide et supérieur à 18 ans
        $aujourdhui = new DateTime();
        $date_naissance = new DateTime($_POST["age"]);
        $diff = $aujourdhui->diff($date_naissance);
        $age_calcul = $diff->y;
        if ($age_calcul < 18) {
            echo "<p>Vous devez avoir plus de 18 ans pour vous inscrire.</p>";
            exit();
        }
        $age = $age_calcul;

        // Hashage du mot de passe
        $hash_mdp = $_POST["hash_mdp1"];
        $options = [
            'cost' => 12,
        ];
        $hash_mdp = password_hash($_POST["hash_mdp1"], PASSWORD_BCRYPT, $options);

        // Requête SQL pour insérer les informations dans la table utilisateur
        $sql = "INSERT INTO utilisateur (email, nom, prenom, age, allergies, ongles_ronges, role, hash_mdp) VALUES (:email, :nom, :prenom, :age, :allergies, :ongles_ronges, :role, :hash_mdp)";

        require "./core/config.php";
        $pdo = new PDO($dsn, $dbuser, $dbpassword);
        $register = $pdo->prepare($sql);

        // Lie les variables à la requête SQL
        $register->bindParam(":role", $role, PDO::PARAM_STR);
        $register->bindParam(":nom", $nom, PDO::PARAM_STR);
        $register->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $register->bindParam(":age", $age, PDO::PARAM_STR);
        $register->bindParam(":allergies", $allergie, PDO::PARAM_STR);
        $register->bindParam(":ongles_ronges", $ongles, PDO::PARAM_STR);
        $register->bindParam(":email", $email, PDO::PARAM_STR);
        $register->bindParam(":hash_mdp", $hash_mdp, PDO::PARAM_STR);

        try {
            if ($register->execute()) {
                // Affiche un message de succès et redirige l'utilisateur vers la page d'accueil
                echo "Compte créé";
                header('Location: index.php?message=compte_cree');
                exit();
            }
        } catch (Exception $e) {
            echo "Message" . $e->getMessage();
        }
    } else {
        echo "Mots de passe différents";
    }
} else {
    echo "Erreur";
}
?>

<h2>Inscription</h2>
<form action="" method="post">
    <div class="info">
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" required>
    </div>
    <div class="info">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
    </div>
    <div class="info">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>
    </div>
    <div class="info">
        <label for="age">Date de naissance :</label>
        <input type="date" name="age" id="age" required>
    </div>
    <div class="info">
    <legend>Allergies:</legend>
<div>
  <input type="checkbox" id="aucune" name="allergies">
  <label for="aucune">Aucune</label>
</div>
<div>
  <input type="checkbox" id="latex" name="allergies">
  <label for="latex">Latex</label>
</div>
<div>
  <input type="checkbox" id="produit_chimique" name="allergies">
  <label for="produit_chimique">Produit chimique</label>
</div>
<div>
  <input type="checkbox" id="autre" name="allergies">
  <label for="autre">Autres</label>
</div>
</fieldset>

    </div>

    <div class="info">
        <legend>Ongles rongés : </legend>
        <div class="choix-etat">
            <div class="bon">
                <input type="radio" name="ongles_ronges" id="oui" value="oui">
                <label for="oui">Oui</label>
            </div>
            <div class="mauvais">
                <input type="radio" name="ongles_ronges" id="non" value="non" checked>
                <label for="non">Non</label>
            </div>
        </div>
    </div>

    <div class="info">
        <label for="mdp1">Mot de passe :</label>
        <input type="password" name="hash_mdp1" id="mpd1" required>
        <label for="mdp2">Vérifier mot de passe :</label>
        <input type="password" name="hash_mdp2" id="mpd2" required>
    </div>
    <input type="hidden" name="role" value="<?= $role ?>">
    <button class="formulaire">envoyer</button>
</form>

<?php
require "./core/footer.php"
?>