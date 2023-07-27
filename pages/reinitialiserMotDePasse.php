<?php
// reinitialiser_motdepasse.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = "Réinitialisation de mot de passe";
require_once "../core/header.php";
require_once "../core/config.php";
require_once "../actions/function.php";

if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);

    try {
        // Vérifier si le token est valide et n'a pas expiré
        $current_time = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM utilisateur WHERE reset_token = :token AND reset_token_expiration > :current_time";
        $query = $pdo->prepare($sql);
        $query->bindParam(':token', $token);
        $query->bindParam(':current_time', $current_time);

        if ($query->execute()) {
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($user)) {
                die("Lien de réinitialisation de mot de passe invalide ou expiré.");
            }

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                    // CSRF token invalide, arrêter l'exécution du script
                    die("Erreur CSRF. Veuillez soumettre le formulaire à nouveau.");
                }

                // Valider le nouveau mot de passe (vous pouvez ajouter d'autres vérifications ici)
                if (isset($_POST['password']) && isset($_POST['confirm_password']) && $_POST['password'] === $_POST['confirm_password']) {
                    // Mettre à jour le mot de passe de l'utilisateur dans la base de données
                    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $sqlUpdatePassword = "UPDATE utilisateur SET hash_mdp = :password_hash, reset_token = NULL, reset_token_expiration = NULL WHERE id = :id";
                    $queryUpdatePassword = $pdo->prepare($sqlUpdatePassword);
                    $queryUpdatePassword->bindParam(':password_hash', $password_hash);
                    $queryUpdatePassword->bindParam(':id', $user['id']);

                    if ($queryUpdatePassword->execute()) {
                        echo "Votre mot de passe a été réinitialisé avec succès.";
                        // Rediriger vers la page de connexion, par exemple :
                        // header("Location: connexion.php");
                        // exit;
                    } else {
                        echo "Une erreur s'est produite lors de la réinitialisation du mot de passe.";
                    }
                } else {
                    echo "Les mots de passe ne correspondent pas.";
                }
            }

            // Générer un nouveau token CSRF pour le formulaire
            $csrf_token = bin2hex(random_bytes(32));
            $_SESSION["csrf_token"] = $csrf_token;

            header('Location: ./login.php');
        }
    } catch (Exception | PDOException | Error $e) {
        $message = "Une erreur s'est produite : " . $e->getMessage();
    }
} else {
    die("Lien de réinitialisation de mot de passe invalide.");
}
?>

<h2>Réinitialisation de mot de passe</h2>
<div class="formulairelog">
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <input type="password" name="password" placeholder="Nouveau mot de passe" autocomplete="new-password">
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" autocomplete="new-password">
        <button><i class="fa-solid fa-check"></i></button>
    </form>
</div
