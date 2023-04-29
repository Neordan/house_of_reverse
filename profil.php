<?php
$page_title = "Mon profil";
require "./core/header.php";
?>
<h2>Mon profil</h2>
<?php if (isset($_SESSION['rdv']['jour_heure']) && !empty($_SESSION['rdv']['jour_heure'])) :
    $rdv_date = new DateTime($_SESSION['rdv']['jour_heure']);
    $formatted_rdv_date = $dateFormaterAvecHeure->format($rdv_date);
?>
    <div class="rdv-details">
        <p>Rendez-vous prévu le: <?= $formatted_rdv_date ?></p>
        <form method="post" action="./delete.php">
            <input type="hidden" name="rdv_id" value="<?= $_SESSION['rdv']['jour_heure'] ?>">
            <button id="deleteRdvButton" type="submit">Supprimer le rendez-vous</button>
        </form>
    </div>
<?php else: ?>
    <p>Aucun rendez-vous prévu pour le moment.</p>
<?php endif; ?>
<form method="post" class="pf-container">
    <div class="compte">
        <div class="pf-struct">
            <input type="text" name="prenom" value="<?= isset($_SESSION['utilisateur']['prenom']) ? ucfirst($_SESSION['utilisateur']['prenom']) : '' ?> " placeholder="Prénom" id="change" disabled>
            <input type="text" name="nom" value="<?= isset($_SESSION['utilisateur']['nom']) ? ucfirst($_SESSION['utilisateur']['nom']) : '' ?>" placeholder="Nom" id="change" disabled>

            <!-- affichage de l'age en int  -->
            <?php
            if (isset($_SESSION['utilisateur']['age'])) {
                $birthdate = new DateTime($_SESSION['utilisateur']['age']);
                $today = new DateTime();
                $interval = $birthdate->diff($today);
                $age = $interval->y;
            } else {
                $age = '';
            }
            ?>
            <input type="text" name="age" value="<?= $age ?> ans" placeholder="Âge" id="change" disabled>
            <input type="text" name="allergies" value="<?= isset($_SESSION['utilisateur']['allergies']) ? $_SESSION['utilisateur']['allergies'] : '' ?>" placeholder="Allergies" id="change" disabled>
            <input type="text" name="email" value="<?= isset($_SESSION['utilisateur']['email']) ? $_SESSION['utilisateur']['email'] : '' ?>" placeholder="Email" id="change" disabled>
        </div>
        <div class="onglet">
            <?php if (!isset($_SESSION['rdv']['jour_heure'])) : ?>
                <a class="prrdv" href="./contact.php">Prendre rendez-vous</a>
            <?php endif ?>
            <form class="deleterdv" action="./delete.php" method="get">
                <input type="hidden" name="<?= $_SESSION['utilisateur']['id'] ?>">
                <a href="delete.php?suppcompte=<?= $_SESSION['utilisateur']['id']; ?>" class="delete" id="deleteAccountButton">Supprimer mon compte</a>
            </form>
        </div>
    </div>
    </div>
</form>

<?php
require "./core/footer.php";
?>