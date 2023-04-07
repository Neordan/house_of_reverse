<?php
require "./core/header.php";
?>
    <form method="post" class="pf-container">
        <h2>Mon profil</h2>
        <div>
            <div class="compte">
                <a href="./logout.php">Déconnexion</a>
                <a href="./contact.php">Prendre rdv</a>
                <div class="pf-struct">
                        <input type="text" name="prenom" value="<?= $_SESSION['utilisateur']['prenom'] ? $_SESSION['utilisateur']['prenom'] : '' ?> " placeholder="Prénom" id="change" disabled>
                        <input type="text" name="nom" value="<?= $_SESSION['utilisateur']['nom'] ? $_SESSION['utilisateur']['nom'] : '' ?>" placeholder="Nom" id="change" disabled>
                        <input type="text" name="age" value="<?= $_SESSION['utilisateur']['age'] ? $_SESSION['utilisateur']['age'] : '' ?>" placeholder="Age" id="change" disabled>
                        <input type="text" name="allergies" value="<?= $_SESSION['utilisateur']['allergies'] ? $_SESSION['utilisateur']['allergies'] : '' ?>" placeholder="Allergies" id="change" disabled>
                        <input type="text" name="ongles_ronges" value="<?= $_SESSION['utilisateur']['ongles_ronges'] == 0 ? "non" : 'oui' ?>" placeholder="Ongles rongés" id="change" disabled>
                        <input type="text" name="email" value="<?= $_SESSION['utilisateur']['email'] ? $_SESSION['utilisateur']['email'] : '' ?>" placeholder="Email" id="change" disabled>
                    </div>
                </div>
                <div class="pf-info">
                    <div class="pf-img">
                        <img src="./assets/img/logo-CCP2.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="pf-btn">
            <button id="btnSave">Enregistrer</button>
        </div>
    </form>


<?php 
require "./core/footer.php";
?>