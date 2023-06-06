<?php
$page_title = "Fichier client";
require "../core/config.php";
require_once "../core/header.php";
require "../actions/function.php";

// Autorisation à l'admin d'aller au fichier client
if ($_SESSION['utilisateur']['role'] != "admin") {
    header("location: ./index.php");
    exit(); // Ajout d'une instruction exit() pour arrêter l'exécution du script après la redirection
}
$q = "";
require "../actions/rechercheUt.php";

// requete sql pour lister les clients
$sql = "SELECT nom, prenom, age, allergies, ongles_ronges FROM utilisateur ORDER BY prenom ASC";


$result = $pdo->prepare($sql);
if ($result->execute()) {
    $users = $result->fetchAll();
} else {
    echo "aucun utilisateur";
}

// lister les rdv
$sql1 = "SELECT nom, prenom, id_rdv, jour_heure 
FROM rdv r 
JOIN utilisateur u ON r.id_utilisateur = u.id ORDER BY jour_heure ASC";


$resultRdv = $pdo->prepare($sql1);
if ($resultRdv->execute()) {
    $rdvs = $resultRdv->fetchAll();
} else {
    echo "Aucun rendez-vous";
}

// lister les infos complémentaires du rendez-vous
$sql2 = "SELECT nom, prenom, id_rdv, jour_heure, inspiration, ongle_actuel, prestation, message 
FROM rdv r 
JOIN utilisateur u ON r.id_utilisateur = u.id ORDER BY jour_heure ASC LIMIT 3";

$resultInfos = $pdo->prepare($sql2);
if ($resultInfos->execute()) {
    $resultInfo = $resultInfos->fetchAll();
} else {
    echo "Aucun rendez-vous";
}
?>


<h2>Liste des utilisateurs</h2>
<div class="rechercheUt">
    <form method="get">
        <input id="search" type="search" name="q" placeholder="Rechercher par utilisateur">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>

<?php if (isset($results) && !empty($results)) : ?>
    <table class="list-user">
        <tr>
            <th>prenom</th>
            <th>nom</th>
            <th>age</th>
            <th>allergies</th>
            <th>ongles rongés</th>
            <!-- Ajoutez les autres colonnes si nécessaire -->
        </tr>
        <?php foreach ($results as $result) : ?>
            <tr>
                <td><?= htmlspecialchars($result['prenom']) ?></td>
                <td><?= htmlspecialchars($result['nom']) ?></td>
                <td><?= htmlspecialchars(calculateAge($result['age'])) ?> ans</td>

                <td><?= htmlspecialchars($result['allergies']) ?></td>
                <td><?= htmlspecialchars($result['ongles_ronges']) ?></td>
                <!-- Ajoutez les autres cellules si nécessaire -->
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <table class="list-user">
        <tr>
            <th>prénom</th>
            <th>nom</th>
            <th>age</th>
            <th>allergies</th>
            <th>ongles rongés</th>
        </tr>
        <?php if (count($users) > 0) :
            foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['prenom'] ?></td>
                    <td><?= $user['nom'] ?></td>
                    <td><?= htmlspecialchars(calculateAge($user['age'])) ?></td>

                    <td><?= $user['allergies'] ?></td>
                    <td><?= htmlspecialchars($user['ongles_ronges']) ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php endif; ?>

<h3>Liste des rendez-vous</h3>
<table class="user">
    <tr>
        <th>prénom</th>
        <th>nom</th>
        <th>rendez-vous</th>
    </tr>
    <?php if (count($rdvs) > 0) {
        foreach ($rdvs as $rdv) { ?>
            <tr>
                <td><?= htmlspecialchars($rdv['prenom']) ?></td>
                <td><?= htmlspecialchars($rdv['nom']) ?></td>
                <td>
                    <?php if (isset($rdv['jour_heure'])) {
                        $rdv_date = new DateTime($rdv['jour_heure']);
                        $formatted_rdv_date = $rdv_date->format('d m Y à H:i');
                        echo htmlspecialchars($formatted_rdv_date);
                    } ?>
                </td>
                <td>
                    <form action="./actions/delete.php" method="get">
                        <input type="hidden" name="id_rdv" value="<?= $rdv['id_rdv'] ?>">
                        <button class="deleterendezvous"><a href="../actions/delete.php?annulation=<?= $rdv['id_rdv']; ?>">Supprimer</a></button>
                    </form>
                </td>
            </tr>
    <?php }
    } else {
        echo "Aucun rendez-vous";
    } ?>
</table>



<h3>Informations des prochains rendez vous</h3>
<?php if (count($resultInfo) > 0) {
    foreach ($resultInfo as $rdv) { ?>
        <div class="info-rdv-client">
            <div class="heurerdv">
                <?php if (isset($rdv['jour_heure'])) :
                    $rdv_date = new DateTime($rdv['jour_heure']);
                    $formatted_rdv_date = $rdv_date->format('d m Y à H:i');
                ?><?= $formatted_rdv_date ?></div>
        <?php endif; ?>
        <div class="pn"><?= htmlspecialchars($rdv['prenom']) ?> <?= htmlspecialchars($rdv['nom']) ?></div>
        <div class="info-presta"><?= htmlspecialchars($rdv['prestation']) ?></div>
        <div class="info-inspi"><img src="./<?= htmlspecialchars($rdv['inspiration']) ?>"></div>
        <div class="info-ongle"><?php if (isset($rdv['ongle_actuel'])) : ?><img src="./<?= htmlspecialchars($rdv['ongle_actuel']) ?>"><?php endif; ?></div>
        <div class="info-message"><?= isset($rdv['message']) ? htmlspecialchars($rdv['message']) : "" ?></div>
        <div class="deleterendezvousclient">
            <form action="./actions/delete.php" method="get">
                <input type="hidden" name="id_rdv" value="<?= $rdv['id_rdv'] ?>">
                <button><a href="../actions/delete.php?annulation= <?= $rdv['id_rdv']; ?>">Supprimer</a></button>
            </form>
        </div>
        </div>
<?php
    }
} else {
    echo "Aucun rendez-vous";
} ?>

<?php require_once "../core/footer.php"; ?>