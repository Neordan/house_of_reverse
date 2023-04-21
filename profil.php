<?php
require "./core/header.php";
?>
    <h2>Mon profil</h2>
    <?= var_dump($_SESSION['rdv']);?>
<form method="post" class="pf-container">
<?php if (isset($_SESSION['rdv'])): ?>
    <div class="rdv-details">
        <p>Rendez-vous prévu le: <?= $_SESSION['rdv'] ?></p>
        <a id="deleteRdvLink" href="delete_rdv.php?rdv_id=<?= $_SESSION['utilisateur']['id'] ?>">Supprimer</a>
        
    </div>
<?php endif; ?>
    <div class="compte">
        <div class="pf-struct">
            <input type="text" name="prenom" value="<?= isset($_SESSION['utilisateur']['prenom']) ? $_SESSION['utilisateur']['prenom'] : '' ?> " placeholder="Prénom" id="change" disabled>
            <input type="text" name="nom" value="<?= isset($_SESSION['utilisateur']['nom']) ? $_SESSION['utilisateur']['nom'] : '' ?>" placeholder="Nom" id="change" disabled>

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
            <a class="prrdv" href="./contact.php">Prendre rendez-vous</a>
            <form class="deleterdv" action="./delete.php" method="get">
                <input type="hidden" name="<?= $_SESSION['utilisateur']['id'] ?>">
                <a href="delete.php?suppcompte=<?= $_SESSION['utilisateur']['id']; ?> class="delete"  id="deleteAccountButton">Supprimer son compte</a>
            </form>
        </div>
    </div>
    </div>
</form>

<?php
require "./core/footer.php";
?>