<?php
$page_title = "Fichier client";
require_once "../core/config.php";
require_once "../core/header.php";
require "../actions/function.php";
require "../actions/delete.php";

// Autorisation à l'admin d'aller au fichier client
if ($_SESSION['utilisateur']['role'] != "admin") {
    header("location: ./index.php");
    exit(); // Ajout d'une instruction exit() pour arrêter l'exécution du script après la redirection
}

// requete sql pour lister les clients
$sql = "SELECT id, nom, prenom, age, allergies, ongles_ronges 
        FROM utilisateur 
        ORDER BY prenom ASC";

$result = $pdo->prepare($sql);
if ($result->execute()) {
    $users = $result->fetchAll();
} else {
    echo "Aucun utilisateur trouvé.";
}

// lister les rdv triés par ordre croissant de jour_heure en joignant deux tables.
$sql = "SELECT r.id_rdv, r.jour_heure, u.nom, u.prenom
         FROM rdv r 
         JOIN utilisateur u 
         ON r.id_utilisateur = u.id 
         ORDER BY r.jour_heure ASC";

$resultRdv = $pdo->prepare($sql);

if ($resultRdv->execute()) {
    $rdvs = $resultRdv->fetchAll();
} else {
    echo "Aucun rendez-vous trouvé.";
}

// lister les infos complémentaires du rendez-vous
$sql = "SELECT r.id_rdv, r.jour_heure, r.inspiration, r.ongle_actuel, r.prestation, r.message, u.nom, u.prenom
        FROM rdv r 
        JOIN utilisateur u 
        ON r.id_utilisateur = u.id 
        ORDER BY r.jour_heure ASC LIMIT 3";

$resultInfos = $pdo->prepare($sql);
if ($resultInfos->execute()) {
    $resultInfo = $resultInfos->fetchAll();
} else {
    echo "Aucun rendez-vous trouvé.";
}

require "../actions/rechercheUt.php";
?>

<h2>Fichier client</h2>
<div class="rechercheUt">
    <form method="get">
        <input id="search" type="search" name="q" placeholder="Rechercher par utilisateur">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>

<h4>Liste des clients</h4>
<table class="list-user">
    <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Âge</th>
        <th>Allergies</th>
        <th>Ongles rongés</th>
        <th>Supprimer</th>
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= htmlspecialchars($user['prenom']) ?></td>
            <td><?= htmlspecialchars($user['nom']) ?></td>
            <td><?= htmlspecialchars(calculateAge($user['age'])) ?></td>
            <td><?= htmlspecialchars($user['allergies']) ?></td>
            <td><?= htmlspecialchars($user['ongles_ronges']) ?></td>
            <td>
                <!-- Utilise un formulaire pour supprimer un compte utilisateur -->
                <form action="../actions/delete.php" method="post">
                    <input type="hidden" name="suppcompte" value="<?= $user['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h4>Liste des rendez-vous</h4>
<?php if (count($rdvs) > 0) : ?>
    <table class="user">
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Rendez-vous</th>
            <th>Supprimer</th>
        </tr>
        <?php foreach ($rdvs as $rdv) : ?>
            <tr>
                <td><?= htmlspecialchars($rdv['prenom']) ?></td>
                <td><?= htmlspecialchars($rdv['nom']) ?></td>
                <td>
                    <?php if (isset($rdv['jour_heure'])) :
                        $formatted_rdv_date = formatDateHeureEnFrancais($rdv['jour_heure']);
                        echo $formatted_rdv_date;
                    endif; ?>
                </td>
                <td>
                    <!-- Utilise un formulaire pour supprimer un rendez-vous -->
                    <form action="../actions/delete.php" method="post">
                        <input type="hidden" name="annulation" value="<?= $rdv['id_rdv']; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>Aucun rendez-vous trouvé.</p>
<?php endif; ?>

<h4>Informations des prochains rendez-vous</h4>
<?php if (count($resultInfo) > 0) : ?>
    <?php foreach ($resultInfo as $rdv) : ?>
        <div class="info-rdv-client">
            <div class="heurerdv">
                <?php if (isset($rdv['jour_heure'])) :
                    $formatted_rdv_date = formatDateHeureEnFrancais($rdv['jour_heure']);
                    echo $formatted_rdv_date;
                endif; ?>
            </div>
            <div class="pn">
                <p>
                    <span>Client.e</span> : <?= htmlspecialchars($rdv['prenom']) ?> <?= htmlspecialchars($rdv['nom']) ?>
                </p>
            </div>
            <div class="info-presta">
                <p>
                    <span>Prestation :</span> <?= htmlspecialchars($rdv['prestation']) ?>
                </p>
            </div>
            <div class="info-inspi">
                <p>Inspiration</p>
                <img src="../<?= htmlspecialchars($rdv['inspiration']) ?>">
            </div>
            <div class="<?= isset($rdv['ongle_actuel']) ? 'info-ongle ongle-actuel' : 'info-ongle'; ?>">
                <p>Ongle actuel</p>
                <?= isset($rdv['ongle_actuel']) ? "<img src=\"../" . htmlspecialchars($rdv['ongle_actuel']) . "\">" : ""; ?>
            </div>
            <div class="info-message">
                <p>Message</p>
                <?= isset($rdv['message']) ? htmlspecialchars($rdv['message']) : "" ?>
            </div>
            <div class="deleterendezvousclient">
                <!-- Utilise un formulaire pour supprimer un rendez-vous -->
                <form action="../actions/delete.php" method="post">
                    <input type="hidden" name="annulation" value="<?= $rdv['id_rdv']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucun rendez-vous trouvé.</p>
<?php endif; ?>

<?php require_once "../core/footer.php"; ?>
