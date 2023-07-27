<?php
$page_title = "Mot de passe oublié";
require_once "../core/header.php";

if (isset($_POST['email'])) {
    // Obtenir l'email saisi par l'utilisateur
    $email = htmlspecialchars(trim($_POST["email"]));

    try {
        // Charger la configuration de la base de données
        require_once "../core/config.php";

        // Vérifier si l'email existe dans la base de données
        $sql = "SELECT * FROM utilisateur WHERE email LIKE :email";
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $email);

        if ($query->execute()) {
            $results = $query->fetch(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                // Générer un token de réinitialisation de mot de passe
                $token = bin2hex(random_bytes(32));

                // Stocker le token de réinitialisation dans la base de données pour l'utilisateur
                $sqlUpdateToken = "UPDATE utilisateur SET reset_token = :token WHERE email LIKE :email";
                $queryUpdateToken = $pdo->prepare($sqlUpdateToken);
                $queryUpdateToken->bindParam(':token', $token);
                $queryUpdateToken->bindParam(':email', $email);

                if ($queryUpdateToken->execute()) {
                    // Envoyer un email à l'utilisateur contenant un lien pour réinitialiser le mot de passe
                    $resetLink = "https://www.houseofreverse.fr/reinitialiserMotDePasse.php?email=" . urlencode($email) . "&token=" . urlencode($token);

                    // Afficher un message à l'utilisateur lui indiquant de vérifier sa boîte de réception pour réinitialiser son mot de passe.
                    echo "Un lien pour réinitialiser votre mot de passe a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception.";
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
?>

<h2>Mot de passe oublié</h2>
<div class="formulairelog">
    <form method="post">
        <input type="text" name="email" placeholder="Email" autocomplete="off">
        <button><i class="fa-solid fa-envelope"></i></button>
    </form>
</div>

<?php
require_once "../core/footer.php";
?>
