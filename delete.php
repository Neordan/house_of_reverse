<?php

require "./core/config.php";

// Fonction pour supprimer un enregistrement dans une table
function delete($table, $idChamp, $idValue, $redirectUrl) {
    // Récupération de l'objet PDO global pour la connexion à la base de données
    global $pdo;

    // Préparation de la requête SQL pour supprimer un enregistrement
    $sql = "DELETE FROM {$table} WHERE {$idChamp}=:id";
    $result = $pdo->prepare($sql);
    // Liaison du paramètre ID à la valeur fournie
    $result->bindParam(':id', $idValue);

    // Exécution de la requête et vérification du succès
    if ($result->execute()) {
        // Redirection vers l'URL spécifiée en cas de succès
        header("Location: {$redirectUrl}");
    } else {
        // Affichage d'un message d'erreur en cas d'échec
        echo "erreur";
    }
}

// Vérification de la présence du paramètre 'annulation'
if (isset($_GET['annulation'])) {
    // Appel de la fonction deleteRecord pour supprimer un rendez-vous
    delete('rdv', 'id_rdv', $_GET['annulation'], './fichierclient.php');
}

// Vérification de la présence du paramètre 'suppcompte'
if (isset($_GET['suppcompte'])) {
    // Appel de la fonction deleteRecord pour supprimer un compte utilisateur
    delete('utilisateur', 'id', $_GET['suppcompte'], './index.php');
    unsetUserSession();
}
