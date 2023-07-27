<?php
$page_title = "Mot de passe oublié";
require_once "../core/header.php";
require_once "../core/config.php";
require_once "../actions/function.php";

// Vérification CSRF
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        // CSRF token invalide, arrêter l'exécution du script
        die("Erreur CSRF. Veuillez soumettre le formulaire à nouveau.");
    }
}

if (isset($_POST['email'])) {
    // Obtenir l'email saisi par l'utilisateur
    $email = htmlspecialchars(trim($_POST["email"]));

    // Valider l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse e-mail invalide.");
    }

    try {
        // Vérifier si l'email existe dans la base de données
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $email);

        if ($query->execute()) {
            $results = $query->fetch(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                // Générer un token de réinitialisation de mot de passe
                $token = bin2hex(random_bytes(32));

                // Stocker le token de réinitialisation dans la base de données pour l'utilisateur
                $sqlUpdateToken = "UPDATE utilisateur SET reset_token = :token WHERE email = :email";
                $queryUpdateToken = $pdo->prepare($sqlUpdateToken);
                $queryUpdateToken->bindParam(':token', $token);
                $queryUpdateToken->bindParam(':email', $email);

                if ($queryUpdateToken->execute()) {
                    // Envoyer un email à l'utilisateur contenant un lien pour réinitialiser le mot de passe
                    $resetLink = "https://www.houseofreverse.fr/reinitialiserMotDePasse.php?email=" . urlencode($email) . "&token=" . urlencode($token);

                    // Envoyer l'email avec la fonction mail() de PHP
                    $to = $email;
                    $subject = "Réinitialisation de mot de passe";
                    $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : " . $resetLink;
                    $headers = "From: contact@houseofreverse.com\r\n";

                    if (mail($to, $subject, $message, $headers)) {
                        // Afficher un message à l'utilisateur lui indiquant de vérifier sa boîte de réception pour réinitialiser son mot de passe.
                        echo "Un lien pour réinitialiser votre mot de passe a été envoyé à votre adresse e-mail. Veuillez vérifier ta boîte de réception ou tes spams.";
                    } else {
                        echo "Une erreur s'est produite lors de l'envoi de l'email. Veuillez réessayer ultérieurement.";
                    }
                } else {
                    echo "Une erreur s'est produite lors de la génération du lien de réinitialisation du mot de passe.";
                }
            } else {
                echo "Adresse e-mail inconnue.";
            }
        }
    } catch (Exception | PDOException | Error $e) {
        // En cas d'erreur, afficher le message d'erreur
        $message = "Une erreur s'est produite : " . $e->getMessage();
    }
}

// Générer un nouveau token CSRF pour le formulaire
$csrf_token = bin2hex(random_bytes(32));
$_SESSION["csrf_token"] = $csrf_token;
?>

<h2>Mot de passe oublié</h2>
<div class="formulairelog">
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <input type="text" name="email" placeholder="Email" autocomplete="off">
        <button><i class="fa-solid fa-envelope"></i></button>
    </form>
</div>

<?php
require_once "../core/footer.php";
?>
