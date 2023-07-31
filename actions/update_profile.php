<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si les champs prénom, nom et email ont été envoyés
    if (
        isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
        isset($_POST["nom"]) && $_POST["nom"] != "" &&
        isset($_POST["email"]) && $_POST["email"] != ""
    ) {
        // Obtenir les valeurs des champs prénom, nom et email
        $prenom = htmlspecialchars(trim($_POST["prenom"]));
        $nom = htmlspecialchars(trim($_POST["nom"]));
        $email = htmlspecialchars(trim($_POST["email"]));

        try {
            // Charger la configuration de la base de données
            require_once "../core/config.php";

            // Préparer la requête SQL pour mettre à jour les données de l'utilisateur
            $sql = "UPDATE utilisateur SET prenom = :prenom, nom = :nom, email = :email WHERE id = :user_id";
            $query = $pdo->prepare($sql);

            // Lier les paramètres aux valeurs
            $query->bindParam(':prenom', $prenom);
            $query->bindParam(':nom', $nom);
            $query->bindParam(':email', $email);
            $query->bindParam(':user_id', $_SESSION['utilisateur']['id']);

            // Exécuter la requête de mise à jour
            if ($query->execute()) {
                // Mettre à jour les valeurs dans la session
                $_SESSION['utilisateur']['prenom'] = $prenom;
                $_SESSION['utilisateur']['nom'] = $nom;
                $_SESSION['utilisateur']['email'] = $email;

                // Rediriger l'utilisateur vers la page de profil mise à jour
                header('Location: profil.php');
                exit;
            } else {
                // En cas d'échec de la mise à jour, afficher un message d'erreur
                echo "Une erreur s'est produite lors de la mise à jour du profil.";
            }
        } catch (Exception | PDOException | Error $e) {
            // En cas d'erreur, afficher le message d'erreur
            $message = "Une erreur s'est produite : " . $e->getMessage();
        }
    }
}
?>
