<?php

require "./core/config.php";
require "./core/header.php";

// Autorisation à l'admin d'aller au fichier client
if ($_SESSION['utilisateur']['role'] != "admin") {
    header("location: ./index.php");
}
$q = "";
require "./rechercheUt.php";

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
JOIN utilisateur u WHERE r.id_utilisateur = u.id ORDER BY jour_heure ASC";


$resultRdv = $pdo->prepare($sql1);
if ($resultRdv->execute()) {
    $rdvs = $resultRdv->fetchAll();
} else {
    echo "Aucun rendez-vous";
}

// lister les infos complémentaires du rendez-vous
$sql2 = "SELECT nom, prenom, id_rdv, jour_heure, inspiration, ongle_actuel, prestation, message 
FROM rdv r 
JOIN utilisateur u WHERE r.id_utilisateur = u.id ORDER BY jour_heure ASC LIMIT 3";

$resultInfos = $pdo->prepare($sql2);
if ($resultInfos->execute()) {
    $resultInfo = $resultInfos->fetchAll();
} else {
    echo "Aucun rendez-vous";
}
?>


<h2>Liste des utilisateurs</h2>
<div class="rechercheUt">
    <form method="get" action="">
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
                <?php
                if (isset($result['age'])) {
                    $birthdate = new DateTime($result['age']);
                    $today = new DateTime();
                    $interval = $birthdate->diff($today);
                    $age = $interval->y;
                } else {
                    $age = '';
                }
                ?>
                <td><?= htmlspecialchars($age) ?></td>
                <td><?= htmlspecialchars($result['allergies']) ?></td>
                <td><?= htmlspecialchars($result['ongles_ronges']) ?></td>
                <!-- Ajoutez les autres cellules si nécessaire -->
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <table class="list-user">
        <tr>
            <th>prenom</th>
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
                    <?php
                    if (isset($user['age'])) {
                        $birthdate = new DateTime($user['age']);
                        $today = new DateTime();
                        $interval = $birthdate->diff($today);
                        $age = $interval->y;
                    } else {
                        $age = '';
                    }
                    ?>
                    <td><?= $age ?></td>
                    <td><?= $user['allergies'] ?></td>
                    <td><?= $user['ongles_ronges'] ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php endif; ?>

<h3>Liste des rendez-vous</h3>
<table class="user">
    <tr>
        <th>prenom</th>
        <th>nom</th>
        <th>rendez-vous</th>
    </tr>
    <?php if (count($rdvs) > 0) {
        foreach ($rdvs as $rdv) : ?>
            <tr>
                <td><?= $rdv['prenom'] ?></td>
                <td><?= $rdv['nom'] ?></td>
                <td><?= $rdv['jour_heure'] ?></td>
                <td>
                    <form action="./delete.php" method="get">
                        <input type="hidden" name="<?= $rdv['id_rdv'] ?>">
                        <button class="delete"><a href="delete.php?annulation=<?= $rdv['id_rdv']; ?>">Supprimer</a></button>
                    </form>
                </td>

            </tr>
    <?php endforeach;
    } else {
        echo "Aucun rendez-vous";
    } ?>
</table>

<h3>Informations des rendez vous prochains</h3>

<table class="info-rdv">
    <tr>
        <th>prenom</th>
        <th>nom</th>
        <th>rendez-vous</th>
        <th>Prestation</th>
        <th>Photo de ses inspirations</th>
        <th>Photo de ses ongles actuels</th>
        <th>Message</th>
    </tr>
    <?php if (count($resultInfo) > 0) {
        foreach ($resultInfo as $rdv) { ?>
            <tr>
                <td><?= $rdv['prenom'] ?></td>
                <td><?= $rdv['nom'] ?></td>
                <td>
                    <?php if (isset($rdv['jour_heure'])) :
                        $rdv_date = new DateTime($rdv['jour_heure']);
                        $formatted_rdv_date = $rdv_date->format('Y-m-d H:i');
                    ?><?= $formatted_rdv_date ?></td>
            <?php endif; ?>
            <td><?= $rdv['prestation'] ?></td>
            <td><img src="./<?= $rdv['inspiration'] ?>"></td>
            <td><?php if (isset($rdv['ongle_actuel'])) : ?><img src="./<?= $rdv['ongle_actuel'] ?>"><?php endif; ?></td>
            <td><?= isset($rdv['message']) ? $rdv['message'] : "" ?></td>
            <td>
                <form action="./delete.php" method="get">
                    <input type="hidden" name="id_rdv" value="<?= $rdv['id_rdv'] ?>">
                    <button class="delete"><a href="delete.php?annulation=<?= $rdv['id_rdv']; ?>">Supprimer</a></button>
                </form>
            </td>
            </tr>
    <?php
        }
    } else {
        echo "Aucun rendez-vous";
    } ?>
</table>

<?php require "./core/footer.php"; ?>