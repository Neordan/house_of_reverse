<?php
$page_title = "Mon profil";
require_once "../core/header.php";
require_once "../actions/function.php";

if (empty($_SESSION['utilisateur'])) {
    // Rediriger l'utilisateur vers la page de connexion
    header('Location: index.php');
    exit;
}

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

<h2>Mon profil</h2>

<?php if (isset($_SESSION['rdv']['jour_heure']) && !empty($_SESSION['rdv']['jour_heure'])) :
    // Formatage de la date et de l'heure du rendez-vous en français
    $formatted_rdv_date = formatDateHeureEnFrancais($_SESSION['rdv']['jour_heure']);
?>

    <div class="rdv-details" id="rdvDetails">
        <!-- Affichage de la date formatée du rendez-vous -->
        <p>Rendez-vous prévu le : <?= $formatted_rdv_date ?></p>
        <!-- Formulaire pour supprimer le rendez-vous -->
        <form method="get" action="../actions/delete.php" class="deleterdv">
            <!-- Champ caché pour stocker l'identifiant du rendez-vous à supprimer -->
            <input type="hidden" name="annulation" value="<?= isset($_SESSION['rdv']['jour_heure']) ? $_SESSION['rdv']['jour_heure'] : '' ?>">
            <button type="submit" class="delete" id="deleteRdvButton">Supprimer mon rendez-vous</button>
        </form>
    </div>

<?php else : ?>

    <p>Aucun rendez-vous prévu pour le moment.</p>

<?php endif; ?>

<div class="compte">
    <form method="post" class="pf-container">
        <?php if (isset($_SESSION['confirmation_message'])) {
            echo '<div class="confirmation-message">' . $_SESSION['confirmation_message'] . '</div>';
            // Supprimez la variable de session après l'affichage du message pour qu'il ne soit affiché qu'une seule fois
            unset($_SESSION['confirmation_message']);
        }
        ?>
        <div class="pf-struct">
            <!-- Champ pour le prénom avec la valeur pré-remplie -->
            <input type="text" name="prenom" value="<?= isset($_SESSION['utilisateur']['prenom']) ? ucfirst($_SESSION['utilisateur']['prenom']) : '' ?>" placeholder="Prénom" id="prenom" disabled>
            <!-- Champ pour le nom avec la valeur pré-remplie -->
            <input type="text" name="nom" value="<?= isset($_SESSION['utilisateur']['nom']) ? ucfirst($_SESSION['utilisateur']['nom']) : '' ?>" placeholder="Nom" id="nom" disabled>
            <!-- Champ pour l'âge avec la valeur pré-remplie (calculée à partir de la fonction calculateAge()) -->
            <input type="text" name="age" value="<?= calculateAge($_SESSION['utilisateur']['age']) ?> ans" placeholder="Âge" id="age" disabled>
            <!-- Champ pour les allergies avec la valeur pré-remplie -->
            <input type="text" name="allergies" value="<?= isset($_SESSION['utilisateur']['allergies']) ? $_SESSION['utilisateur']['allergies'] : '' ?>" placeholder="Allergies" id="allergies" disabled>
            <!-- Champ pour l'email avec la valeur pré-remplie -->
            <input type="text" name="email" value="<?= isset($_SESSION['utilisateur']['email']) ? $_SESSION['utilisateur']['email'] : '' ?>" placeholder="Email" id="email" disabled>
        </div>
        <div class="onglet">
            <?php
            if (!isset($_SESSION['rdv']['jour_heure'])) : ?>
                <!-- Lien vers la page pour prendre rendez-vous -->
                <a class="prrdv" href="./contact.php" id="takeRdv">Prendre rendez-vous</a>
            <?php endif ?>
            <!-- Bouton pour activer l'édition des champs -->
            <a type="button" class="prrdv" id="editProfileButton">Modifier mon profil</a>
            <a type="submit" class="prrdv" id="saveProfileButton" style="display: none;">Enregistrer mes modifications</a>

            <!-- Formulaire pour supprimer le compte -->
            <form method="get" action="../actions/delete.php" class="deleterdv">
                <a href="../actions/delete.php?suppcompte=<?= $_SESSION['utilisateur']['id']; ?>" class="delete" id="deleteAccountButton">Supprimer mon compte</a>
            </form>
        </div>
    </form>
</div>


<?php
require_once "../core/footer.php";
?>