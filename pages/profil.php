<?php
$page_title = "Mon profil";
require_once "../core/header.php";
require_once "../actions/function.php";
?>

<h2>Mon profil</h2>

<?php if (isset($_SESSION['rdv']['jour_heure']) && !empty($_SESSION['rdv']['jour_heure'])) :
    // Formatage de la date et de l'heure du rendez-vous en français
    $formatted_rdv_date = formatDateHeureEnFrancais($_SESSION['rdv']['jour_heure']);
?>

    <div class="rdv-details">
        <!-- Affichage de la date formatée du rendez-vous -->
        <p>Rendez-vous prévu le : <?= $formatted_rdv_date ?></p>
        <!-- Formulaire pour supprimer le rendez-vous -->
        <form method="get" action="../actions/delete.php">
            <!-- Champ caché pour stocker l'identifiant du rendez-vous à supprimer -->
            <input type="hidden" name="rdv_id" value="<?= $_SESSION['rdv']['jour_heure'] ?>">
            <button id="deleteRdvButton" type="submit">Supprimer le rendez-vous</button>
        </form>
    </div>

<?php else : ?>

    <p>Aucun rendez-vous prévu pour le moment.</p>

<?php endif; ?>

<div class="compte">
    <form method="post" class="pf-container">
        <div class="pf-struct">
            <!-- Champ pour le prénom avec la valeur pré-remplie -->
            <input type="text" name="prenom" value="<?= isset($_SESSION['utilisateur']['prenom']) ? ucfirst($_SESSION['utilisateur']['prenom']) : '' ?> " placeholder="Prénom" id="change" disabled>
            <!-- Champ pour le nom avec la valeur pré-remplie -->
            <input type="text" name="nom" value="<?= isset($_SESSION['utilisateur']['nom']) ? ucfirst($_SESSION['utilisateur']['nom']) : '' ?>" placeholder="Nom" id="change" disabled>
            <!-- Champ pour l'âge avec la valeur pré-remplie (calculée à partir de la fonction calculateAge()) -->
            <input type="text" name="age" value="<?= calculateAge($_SESSION['utilisateur']['age']) ?> ans" placeholder="Âge" id="change" disabled>
            <!-- Champ pour les allergies avec la valeur pré-remplie -->
            <input type="text" name="allergies" value="<?= isset($_SESSION['utilisateur']['allergies']) ? $_SESSION['utilisateur']['allergies'] : '' ?>" placeholder="Allergies" id="change" disabled>
            <!-- Champ pour l'email avec la valeur pré-remplie -->
            <input type="text" name="email" value="<?= isset($_SESSION['utilisateur']['email']) ? $_SESSION['utilisateur']['email'] : '' ?>" placeholder="Email" id="change" disabled>
        </div>
        <div class="onglet">
            <?php
            if (!isset($_SESSION['rdv']['jour_heure'])) : ?>
                <!-- Lien vers la page pour prendre rendez-vous -->
                <a class="prrdv" href="./contact.php">Prendre rendez-vous</a>
            <?php endif ?>
            <!-- Formulaire pour supprimer le rendez-vous -->
            <form class="deleterdv" action="../actions/delete.php" method="get">

                <!-- Lien pour supprimer le compte utilisateur -->
                <a href="/actions/delete.php?suppcompte=<?= $_SESSION['utilisateur']['id']; ?>" class="delete" id="deleteAccountButton">Supprimer mon compte</a>
            </form>
        </div>
    </form>
</div>

<?php
require_once "../core/footer.php";
?>