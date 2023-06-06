<?php
$page_title = "Mon profil";
require_once "../core/header.php";
require_once "../actions/function.php";

// Objet permettant de formater une date en français en toute lettre
$dateFormaterAvecHeure = new IntlDateFormatter(
    'fr-FR',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN,
    "EEEE d MMMM yyyy 'à' HH:mm"
);
?>
<h2>Mon profil</h2>
<?php if (isset($_SESSION['rdv']['jour_heure']) && !empty($_SESSION['rdv']['jour_heure'])) :
    $rdv_date = new DateTime($_SESSION['rdv']['jour_heure']);
    $formatted_rdv_date = $dateFormaterAvecHeure->format($rdv_date);
?>
    <div class="rdv-details">
        <p>Rendez-vous prévu le: <?= $formatted_rdv_date ?></p>
        <form method="get" action="../actions/delete.php">
            <input type="hidden" name="rdv_id" value="<?= $_SESSION['rdv']['jour_heure'] ?>">
            <button id="deleteRdvButton" type="submit">Supprimer le rendez-vous</button>
        </form>

    </div>
<?php else : ?>
    <p>Aucun rendez-vous prévu pour le moment.</p>
    <?php if (isset($_SESSION['rdv']['jour_heure'])) : ?>
        <p>Vous avez annulé votre rendez-vous.</p>
    <?php endif; ?>
<?php endif; ?>
<div class="compte">
    <form method="post" class="pf-container">
        <div class="pf-struct">
            <input type="text" name="prenom" value="<?= isset($_SESSION['utilisateur']['prenom']) ? ucfirst($_SESSION['utilisateur']['prenom']) : '' ?> " placeholder="Prénom" id="change" disabled>
            <input type="text" name="nom" value="<?= isset($_SESSION['utilisateur']['nom']) ? ucfirst($_SESSION['utilisateur']['nom']) : '' ?>" placeholder="Nom" id="change" disabled>



            <input type="text" name="age" value="<?= calculateAge($_SESSION['utilisateur']['age']) ?> ans" placeholder="Âge" id="change" disabled>
            <input type="text" name="allergies" value="<?= isset($_SESSION['utilisateur']['allergies']) ? $_SESSION['utilisateur']['allergies'] : '' ?>" placeholder="Allergies" id="change" disabled>
            <input type="text" name="email" value="<?= isset($_SESSION['utilisateur']['email']) ? $_SESSION['utilisateur']['email'] : '' ?>" placeholder="Email" id="change" disabled>
        </div>
        <div class="onglet">
            <?php if (!isset($_SESSION['rdv']['jour_heure'])) : ?>
                <a class="prrdv" href="./contact.php">Prendre rendez-vous</a>
            <?php endif ?>
            <form class="deleterdv" action="../actions/delete.php" method="get">
                <input type="hidden" name="<?= $_SESSION['utilisateur']['id'] ?>">
                <a href="delete.php?suppcompte=<?= $_SESSION['utilisateur']['id']; ?>" class="delete" id="deleteAccountButton">Supprimer mon compte</a>

            </form>
        </div>
    </form>
</div>

<?php
require_once "../core/footer.php";
?>