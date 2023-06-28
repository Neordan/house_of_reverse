<?php
$page_title = "Inscription";
require_once "../core/header.php";
require "../actions/function.php";



$allergies_options = getAllergiesOptions();

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
        
        if (isset($_POST['allergies'])) {
            //suite d'allergie séparé par une virgule
            $allergies = implode(", ", $_POST['allergies']);
        }
        
        $ongles = $_POST["ongles_ronges"];
        
        // Hashage du mot de passe
        $hash_mdp = $_POST["hash_mdp1"];
        $options = [
            'cost' => 12,
        ];
        $hash_mdp = password_hash($_POST["hash_mdp1"], PASSWORD_BCRYPT, $options);
        
        require_once "../core/config.php";
        // Requête SQL pour insérer les informations dans la table utilisateur
        $sql = "INSERT INTO utilisateur (email, nom, prenom, age, allergies, ongles_ronges, role, hash_mdp) VALUES (:email, :nom, :prenom, :age, :allergies, :ongles_ronges, :role, :hash_mdp)";


        $register = $pdo->prepare($sql);

        // Lie les variables à la requête SQL
        $register->bindParam(":role", $role, PDO::PARAM_STR);
        $register->bindParam(":nom", $nom, PDO::PARAM_STR);
        $register->bindParam(":prenom", $prenom, PDO::PARAM_STR);
        $register->bindParam(":age", $age, PDO::PARAM_STR);
        $register->bindParam(":allergies", $allergies, PDO::PARAM_STR);
        $register->bindParam(":ongles_ronges", $ongles, PDO::PARAM_STR);
        $register->bindParam(":email", $email, PDO::PARAM_STR);
        $register->bindParam(":hash_mdp", $hash_mdp, PDO::PARAM_STR);

        try {
            if ($register->execute()) {
                $lastInsertId = $pdo->lastInsertId();
                $_SESSION['utilisateur']['id'] = $lastInsertId;
                $_SESSION['utilisateur']['nom'] = $nom;
                $_SESSION['utilisateur']['prenom'] = $prenom;
                $_SESSION['utilisateur']['age'] = $age;
                $_SESSION['utilisateur']['allergies'] = $allergies;
                $_SESSION['utilisateur']['ongles_ronges'] = $ongles;
                $_SESSION['utilisateur']['email'] = $email;
                $_SESSION['utilisateur']['role'] = $role;
                header('Location: ./profil.php');
                exit();
            } else {
                echo "Erreur lors de l'exécution de la requête.";
            }
        } catch (Exception $e) {
            echo "Message" . $e->getMessage();
        }
    } else {
        echo "Mots de passe différents";
    }
}
?>

<h2>Inscription</h2>
<form class="register" method="post">
    <div class="info">
        <label for="email">Quel est ton e-mail ? <span>*</span></label>
        <input type="text" name="email" id="email" autocomplete="off" required>
    </div>
    <div class="info">
        <label for="nom">Quel est ton nom ? <span>*</span></label>
        <input type="text" name="nom" id="nom" autocomplete="off" required>
    </div>
    <div class="info">
        <label for="prenom">Quel est ton prénom ? <span>*</span></label>
        <input type="text" name="prenom" id="prenom" autocomplete="off" required>
    </div>
    <div class="info">
        <label for="age">Quel est ta date de naissance ? <span>*</span></label>
        <input type="date" name="age" id="age" autocomplete="off" required>
    </div>
    <div class="info">
        <label class="label-allergie" for="allergies" autocomplete="off">As tu des allergies ? <span>*</span></label><br>
        <div class="allergies">
            <?php $allergies_options = getAllergiesOptions();
            foreach ($allergies_options as $key => $value) : ?>
                <div class="allergie">
                    <input type="checkbox" id="<?= $key ?>" name="allergies[]" value="<?= $key ?>">
                    <label for="<?= $key ?>"><?= $value ?></label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="info">
        <legend>Te ronges tu les ongles ? <span>*</span></legend>
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
        <label for="mdp1">Quel est ton mot de passe : <span>*</span></label>
        <input type="password" name="hash_mdp1" id="mpd1" autocomplete="off" required>
    </div>
    <div class="info">
        <label for="mdp2">Vérifie le : <span>*</span></label>
        <input type="password" name="hash_mdp2" id="mpd2" autocomplete="off" required>
    </div>
    <input type="hidden" name="role" value="<?= $role ?>">
    <button class="formulaire"><i class="fa-solid fa-check"></i></button>
</form>

<?php
require_once "../core/footer.php"
?>