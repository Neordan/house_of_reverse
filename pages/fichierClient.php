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
$sql = "SELECT nom, prenom, age, allergies, ongles_ronges 
        FROM utilisateur 
        ORDER BY prenom ASC";

$result = $pdo->prepare($sql);
if ($result->execute()) {
    $users = $result->fetchAll();
} else {
    echo "aucun utilisateur";
}

// lister les rdv triés par ordre croissant de jour_heure en joignant deux tables.
$sql = "SELECT nom, prenom, id_rdv, jour_heure 
         FROM rdv r 
         JOIN utilisateur u 
         ON r.id_utilisateur = u.id 
         ORDER BY jour_heure ASC";

// Préparation de la requête SQL & elle est stockée dans $resultRdv. 
$resultRdv = $pdo->prepare($sql);

// Si l'exécution réussit, le bloc de code suivant est exécuté.
if ($resultRdv->execute()) {
    // Récupère tous les résultats de la requête et les stocke dans la variable $rdvs.
    $rdvs = $resultRdv->fetchAll();
} else {
    // Affiche le message "Aucun rendez-vous".
    echo "Aucun rendez-vous";
}

// lister les infos complémentaires du rendez-vous
$sql = "SELECT nom, prenom, id_rdv, jour_heure, inspiration, ongle_actuel, prestation, message 
        FROM rdv r 
        JOIN utilisateur u 
        ON r.id_utilisateur = u.id 
        ORDER BY jour_heure ASC LIMIT 3";

$resultInfos = $pdo->prepare($sql);
if ($resultInfos->execute()) {
    $resultInfo = $resultInfos->fetchAll();
} else {
    echo "Aucun rendez-vous";
}
?>

<h2>Fichier client</h2>
<div class="rechercheUt">
    <form method="get">
        <input id="search" type="search" name="q" placeholder="Rechercher par utilisateur">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>

<h4>Liste des clients</h4>

<!-- Vérification si des résultats sont disponibles -->
<?php if (isset($results) && !empty($results)) : ?>
    <!-- Affiche les résultats de la barre de recherche -->
    <table class="list-user">
        <tr>
            <th>prenom</th>
            <th>nom</th>
            <th>age</th>
            <th>allergies</th>
            <th>ongles rongés</th>
        </tr>
        <?php foreach ($results as $result) : ?>
            <tr>
                <td><?= htmlspecialchars($result['prenom']) ?></td>
                <td><?= htmlspecialchars($result['nom']) ?></td>
                <td><?= htmlspecialchars(calculateAge($result['age'])) ?></td>
                <td><?= htmlspecialchars($result['allergies']) ?></td>
                <td><?= htmlspecialchars($result['ongles_ronges']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <!-- si aucune recherche alors ça affiche tout les utilisateurs -->
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
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php endif; ?>

<h4>Liste des rendez-vous</h4>

<!-- Vérification si des rendez-vous sont disponibles -->
<?php if (count($rdvs) > 0) { ?>
    <table class="user">
        <tr>
            <th>prénom</th>
            <th>nom</th>
            <th>rendez-vous</th>
            <th>annuler</th>
        </tr>
        <?php foreach ($rdvs as $rdv) { ?>
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
                    <form action="./actions/delete.php" method="get">
                        <!-- Utilise un formulaire pour supprimer un rendez-vous -->
                        <button class="deleterendezvous"><a href="../actions/delete.php?annulation=<?= $rdv['id_rdv']; ?>">Supprimer</a></button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } else {
    echo "Aucun rendez-vous";
} ?>




<h4>Informations des prochains rendez vous</h4>
<?php if (count($resultInfo) > 0) {
    foreach ($resultInfo as $rdv) { ?>
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
                <form action="./actions/delete.php" method="get">
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