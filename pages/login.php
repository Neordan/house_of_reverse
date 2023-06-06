<?php
$page_title = "Se connecter";
require_once "../core/header.php";

// Vérifier si les champs email et mot de passe sont définis et non vides
if (isset($_POST["email"]) && $_POST["email"] != "" &&
    isset($_POST["hash_mdp"]) && $_POST["hash_mdp"] != "") {
    // Obtenir les valeurs des champs email et mot de passe et supprimer tout caractère inutile au début et à la fin
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars(trim($_POST["hash_mdp"]));

    try {
        // Charger la configuration de la base de données
        require_once "./core/config.php";

        // Préparer la requête SQL pour récupérer l'utilisateur correspondant à l'email fourni
        $sql = "SELECT * FROM utilisateur WHERE email LIKE :email";
        $query = $pdo->prepare($sql);

        // Lier le paramètre de l'email à la valeur de l'email récupérée
        $query->bindParam(':email', $email);

        // Exécuter la requête et obtenir les résultats
        if ($query->execute()) {
            $results = $query->fetch(PDO::FETCH_ASSOC);
        }

        // Vérifier si l'utilisateur existe dans la base de données
        if (empty($results)) {
            echo "Adresse e-mail inconnue.";
        } else {
            // Vérifier si le mot de passe fourni correspond au hash de mot de passe stocké dans la base de données
            if (password_verify($password, $results['hash_mdp'])) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['utilisateur']['id'] = $results['id'];
                $_SESSION['utilisateur']['nom'] = $results['nom'];
                $_SESSION['utilisateur']['prenom'] = $results['prenom'];
                $_SESSION['utilisateur']['age'] = $results['age'];
                $_SESSION['utilisateur']['allergies'] = $results['allergies'];
                $_SESSION['utilisateur']['ongles_ronges'] = $results['ongles_ronges'];
                $_SESSION['utilisateur']['email'] = $results['email'];
                $_SESSION['utilisateur']['role'] = $results['role'];

                // Rediriger l'utilisateur vers la page appropriée en fonction de son rôle (admin ou utilisateur)
                if ($results['role'] == "admin") {
                    header('Location: fichierClient.php');
                } else {
                    header('Location: profil.php');
                }
            } else {
                echo "Mot de passe incorrect.";
            }
        }
    } catch (Exception | PDOException | Error $e) {
        // En cas d'erreur, afficher le message d'erreur
        $message = "Une erreur s'est produite : " . $e->getMessage();
    }
}

?>
<h2>Connexion</h2>
<div class="formulairelog">
    <form method="post">
        <input type="text" name="email" placeholder="Email" autocomplete="off">
        <input type="password" name="hash_mdp" placeholder="Mot de passe" autocomplete="off">
        <a class="mdp" href="#">Mot de passe oublié ?</a>
        <a href="./register.php">S'inscrire</a>
        <button><i class="fa-solid fa-unlock"></i></button>
    </form>
</div>

<?php
require_once "../core/footer.php";
?>