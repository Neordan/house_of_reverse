<?php
if (isset($_POST['email']) && isset($_POST['token']) && isset($_POST['nouveau_mdp'])) {
    $email = htmlspecialchars(trim($_POST["email"]));
    $token = htmlspecialchars(trim($_POST["token"]));
    $nouveauMdp = htmlspecialchars(trim($_POST["nouveau_mdp"]));

    try {
        // Charger la configuration de la base de données
        require_once "../core/config.php";

        // Vérifier si l'email et le token correspondent dans la base de données
        $sql = "SELECT * FROM utilisateur WHERE email LIKE :email AND reset_token LIKE :token";
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $email);
        $query->bindParam(':token', $token);

        if ($query->execute()) {
            $results = $query->fetch(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                // Hasher et mettre à jour le nouveau mot de passe dans la base de données
                $hashedPassword = password_hash($nouveauMdp, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe et supprimer le token de réinitialisation dans la base de données
                $sqlUpdatePassword = "UPDATE utilisateur SET hash_mdp = :hashedPassword, reset_token = NULL WHERE email LIKE :email";
                $queryUpdatePassword = $pdo->prepare($sqlUpdatePassword);
                $queryUpdatePassword->bindParam(':hashedPassword', $hashedPassword);
                $queryUpdatePassword->bindParam(':email', $email);

                if ($queryUpdatePassword->execute()) {
                    echo "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.";
                } else {
                    echo "Une erreur s'est produite lors de la réinitialisation de votre mot de passe.";
                }
            } else {
                echo "Lien de réinitialisation du mot de passe invalide.";
            }
        }
    } catch (Exception | PDOException | Error $e) {
        // En cas d'erreur, afficher le message d'erreur
        $message = "Une erreur s'est produite : " . $e->getMessage();
    }
}
