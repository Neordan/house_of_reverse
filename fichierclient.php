<?php

require "./core/header.php";

//Autorisation à l'admin d'aaler au fichier client
// if ($_SESSION['utilisateur']['role'] != "admin") {
//     header ("location: ./index.php");
// }

// requete sql pour lister les clients
$sql = "SELECT nom, prenom, age, allergies, ongles_ronges FROM utilisateur ORDER BY prenom ASC ";

require "./core/config.php";

$result = $pdo->prepare($sql);
if ($result->execute()) {
    $users = $result->fetchAll();
} else {
    echo "aucun utilisateur";
}

//lister les rdv
$sql1 = "SELECT nom, prenom, id_rdv, jour_heure 
FROM rdv r 
JOIN utilisateur u WHERE r.id_utilisateur = u.id ORDER BY jour_heure ASC";

require "./core/config.php";

$resultRdv = $pdo->prepare($sql1);
if ($resultRdv->execute()) {
    $rdvs = $resultRdv->fetchAll();
} else {
    echo "aucun rdv";
}
?>

<h2>Liste des utilisateurs</h2>
<table>
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
                <td><?= $user['age'] ?></td>
                <td><?= $user['allergies'] ?></td>
                <td><?= $user['ongles_ronges'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<h3>Liste des rendez-vous</h3>
<table>
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
                        <input type="hidden" name="<?= $rdv['id_rdv']?>">
                        <button class="delete"><a href="delete.php?annulation=<?php echo $rdv['id_rdv']; ?>">Supprimer</a></button>
                    </form>
                </td>

            </tr>
        <?php endforeach; 
        } else { 
            echo "Aucun rendez-vous";
        } ?>

</table>

<?php require "./core/footer.php"; ?>