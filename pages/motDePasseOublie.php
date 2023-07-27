<?php
// motdepasse_oublie.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = "Mot de passe oublié";
require_once "../core/header.php";
require_once "../core/config.php";
require_once "../actions/function.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        // CSRF token invalide, arrêter l'exécution du script
        die("Erreur CSRF. Veuillez soumettre le formulaire à nouveau.");
    }

    if (isset($_POST['email'])) {
        $email = htmlspecialchars(trim($_POST["email"]));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Adresse e-mail invalide.");
        }

        try {
            $sql = "SELECT * FROM utilisateur WHERE email = :email";
            $query = $pdo->prepare($sql);
            $query->bindParam(':email', $email);

            if ($query->execute()) {
                $user = $query->fetch(PDO::FETCH_ASSOC);

                if (!empty($user)) {
                    // Générer un token de réinitialisation de mot de passe
                    $token = bin2hex(random_bytes(32));

                    // Stocker le token de réinitialisation dans la base de données avec une date d'expiration
                    $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    $sqlUpdateToken = "UPDATE utilisateur SET reset_token = :token, reset_token_expiration = :expiration WHERE id = :id";
                    $queryUpdateToken = $pdo->prepare($sqlUpdateToken);
                    $queryUpdateToken->bindParam(':token', $token);
                    $queryUpdateToken->bindParam(':expiration', $expiration);
                    $queryUpdateToken->bindParam(':id', $user['id']);

                    if ($queryUpdateToken->execute()) {
                        // Rediriger vers la page de réinitialisation de mot de passe avec le token
                        header("Location: reinitialiserMotDePasse.php?token=" . urlencode($token));
                        exit;
                    } else {
                        echo "Une erreur s'est produite lors de la génération du lien de réinitialisation du mot de passe.";
                    }
                } else {
                    echo "Adresse e-mail inconnue.";
                }
            }
        } catch (Exception | PDOException | Error $e) {
            $message = "Une erreur s'est produite : " . $e->getMessage();
        }
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
