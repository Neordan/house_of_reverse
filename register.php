<?php
require "./core/header.php";

// vérifier que le formulaire a bien été envoyé
if (!empty($_POST)) {

    // vérifier que chaque donnée existe et n'est pas vide
    if ( isset($_POST["email"]) && $_POST["email"] != "" && 
         isset($_POST["nom"]) && $_POST["nom"] != "" &&
         isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
         isset($_POST["age"]) && $_POST["age"] != "" &&
         isset($_POST["allergie"]) && $_POST["allergie"] != "" &&
         isset($_POST["ongle"]) && $_POST["ongle"] != "" &&
         isset($_POST["hash_mpd1"]) && $_POST["hash_mpd1"] != "" &&
         isset($_POST["hash_mpd2"]) && $_POST["hash_mpd2"] != "") {
            
             //pour retirer les espaces et convertir les caractères spéciaux en entités HTML pour afficher sans interprétés
             $nom = htmlspecialchars(trim($_POST["nom"]));
             $prenom = htmlspecialchars(trim($_POST["prenom"]));
             $age = htmlspecialchars(trim($_POST["age"]));
             $allergie = htmlspecialchars(trim($_POST["allergie"]));
             $ongle = htmlspecialchars(trim($_POST["ongle"]));
             $email = htmlspecialchars(trim($_POST["email"]));
             $role = "utilisateur";
            // vérifie la similarité des deux mot de passe
            if ($_POST["hash_mpd1"] == $_POST["hash_mpd2"]) {
            
                //vérifie la complexité et la longueur de la chaîne de caractères de mot de passe soumise
                if (preg_match('/[\'^£$%&*()}{@#~?><>,_|=+¬-]/', $_POST["hash_mpd1"]) || strlen($_POST["hash_mpd1"]) < 6) {
                    echo "<p>Mot de passe invalide : doit contenir au moins 6 caractères et/ou pas de caractères spéciaux.</p>";
                } else {
                    // le mot de passe de confirmation
                    $hash_mpd = $_POST["hash_mpd1"];
                    // A remplacer pour hasher le mot de passe par:
                    $options = [
                        'cost' => 12,
                    ];
        
                    //hashage du mot de passe
                    $hash_mpd = password_hash($_POST["hash_mpd1"], PASSWORD_BCRYPT, $options);
                }
            

            // Requête SQL
            $sql = "INSERT INTO utilisateur (role, nom, prenom, age, allergie, ongle, email) VALUES (:role, :nom, :prenom, :age, :allergie, :ongle, :email);";
            
            // Connexion à la base de données
            require "./core/config.php";
            
            // Préparer la requête  
            $register = $pdo->prepare($sql);

            // Liaison des paramètres de la requête préparée pour la sécurité
            $register->bindParam(":role", $role, PDO::PARAM_STR);
            $register->bindParam(":nom", $nom, PDO::PARAM_STR);
            $register->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $register->bindParam(":age", $age, PDO::PARAM_STR);
            $register->bindParam(":allergie", $allergie, PDO::PARAM_STR);
            $register->bindParam(":ongle", $ongle, PDO::PARAM_STR);
            $register->bindParam(":email", $email, PDO::PARAM_STR);
            var_dump($email);

            // Exécution de la requête
            if ($register->execute()) {
                echo "<p>Ton compte a bien été créé !</p>";
                header("location: login.php");
                exit();
            } else {
                echo "<p>Une erreur s'est produite</p>";
            }
        } else {
            // Les deux mots de passes saisis sont différents
            echo "<p>mots de passe différents</p>";
        }
    } else {
        echo "Champs obligatoires absents";
    }
}
var_dump($age);
?>

<h2>Inscription</h2>
<form action="" method="post" >
    <div class="info">
        <label for="email">Email :</label>
        <input type="text" name="email" id="email">
    </div>
    <div class="info">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom">
    </div>
    <div class="info">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom">
    </div>
    <div class="info">
        <label for="age">Date de naissance :</label>
        <input type="date" name="age" id="age">
    </div>
    <div class="info">
        <label for="allergie">Allergies :</label>
        <select name="allergie" id="allergie">
            <option value="aucun">aucune</option>
            <option value="latex">Latex</option>
            <option value="produit chimique">produit chimique</option>
            <option value="autre">autre</option>
        </select>
    </div>

    <div class="info">
        <legend>Ongles rongés : </legend>
        <div class="choix-etat">
            <div class="bon">
                <input type="radio" name="ongle" id="oui">
                <label for="oui">Oui</label>
            </div>
            <div class="mauvais">
                <input type="radio" name="ongle" id="non">
                <label for="non">Non</label>
            </div>
        </div>
        <div class="info">
        <label for="mdp1">Mot de passe :</label>
            <input type="password" name="hash_mdp1" id="mpd1">
            <label for="mdp2">Vérifier mot de passe :</label>
            <input type="password" name="hash_mdp2" id="mpd2">
        </div>
    </div>
    <button class="formulaire">envoyer</button>
</form>

<?php
require "./core/footer.php"
?>