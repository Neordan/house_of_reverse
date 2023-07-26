<?php


$page_title = "Inscription";
require_once "../core/header.php";
require "../actions/function.php";

$allergies_options = getAllergiesOptions();
$role = "utilisateur";

// Vérifie si le formulaire a été envoyé
if (!empty($_POST)) {

    // Vérifier le reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = "6LchyEknAAAAAN1qfYaGjTow8p96i-FkemQ1vUO0";
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array('secret' => $secretKey, 'response' => $recaptchaResponse);

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $recaptchaResult = json_decode($response);

    // Vérifie si le reCAPTCHA est valide
    if (!$recaptchaResult->success) {
        echo "Veuillez cocher la case reCAPTCHA avant de soumettre le formulaire.";
        exit();
    }

    // Vérifie que les mots de passe sont identiques
    if ($_POST["hash_mdp1"] != $_POST["hash_mdp2"]) {
        echo "Les mots de passe ne correspondent pas.";
    } elseif (strlen($_POST["hash_mdp1"]) < 6 || !preg_match("/[0-9]/", $_POST["hash_mdp1"]) || !preg_match("/[!@#$%^&*()_+\-=\[\]{};':\"|,.<>\/?]/", $_POST["hash_mdp1"])) {
        echo "Le mot de passe doit contenir au moins 6 caractères, un chiffre et un symbole.";
    } else {
        // Initialise les variables
        $email = htmlspecialchars(trim($_POST["email"]));
        $nom = htmlspecialchars(trim($_POST["nom"]));
        $prenom = htmlspecialchars(trim($_POST["prenom"]));
        $age = $_POST["age"];

        if (isset($_POST['allergies'])) {
            //suite d'allergie séparé par une virgule
            $allergies = implode(", ", $_POST['allergies']);
        }

        $ongles = $_POST["ongles_ronges"];

        // Hashage du mot de passe
        $hash_mdp = trim($_POST["hash_mdp1"]);
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
                echo "Redirection vers login.php"; // Message de débogage
                header('Location: ./profil.php');
                exit();
            } else {
                echo "Erreur lors de l'exécution de la requête.";
            }
        } catch (Exception $e) {
            echo "Message" . $e->getMessage();
        }
    }
}
?>

<h2>Inscription</h2>
<form class="register" method="post">
    <div class="info">
        <label for="email">Quel est ton e-mail ? <span>*</span></label>
        <input type="text" name="email" id="email" autocomplete="on" required>
        <div class="error-message"></div>
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

    <div class="info password-container">
        <label for="mdp1">Quel est ton mot de passe : <span>*</span></label>
        <input type="password" name="hash_mdp1" id="password" autocomplete="off" required>
        <div class="error-message"></div>
    </div>
    <div class="info confirm-container">
        <label for="mdp2">Vérifie le : <span>*</span></label>
        <input type="password" name="hash_mdp2" id="confirm" autocomplete="off" required>
        <div class="error-message"></div>
    </div>
    <input type="hidden" name="role" value="<?= $role ?>">
    <div class="g-recaptcha" data-sitekey="6LchyEknAAAAAEcHU9WHe2goizMCBf-QRq05X5w6"></div>
    <button class="formulaire"><i class="fa-solid fa-check"></i></button>
</form>

<?php
require_once "../core/footer.php"
?>