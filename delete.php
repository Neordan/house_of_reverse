<?php
session_start();

// Fonction générique pour supprimer un enregistrement dans une table
function deleteRecord($table, $idChamp, $idValue, $redirectUrl, $sessionKey = null) {
    require "./core/config.php";

    // Préparation de la requête SQL pour supprimer un enregistrement
    $sql = "DELETE FROM {$table} WHERE {$idChamp}=:id";
    $result = $pdo->prepare($sql);
    // Liaison du paramètre ID à la valeur fournie
    $result->bindParam(':id', $idValue);

    // Exécution de la requête et vérification du succès
    if ($result->execute()) {
        if (!is_null($sessionKey)) {
            // Suppression de la variable spécifiée dans la session
            unset($_SESSION[$sessionKey]);
        }
        // Redirection vers l'URL spécifiée en cas de succès
        header("Location: {$redirectUrl}");
        exit(); // Terminer le script
    } else {
        // Affichage d'un message d'erreur en cas d'échec
        echo "Erreur : La suppression a échoué.";
    }
}

// Vérification de la présence du paramètre 'annulation'
if (isset($_GET['annulation'])) {
    // Appel de la fonction deleteRecord pour supprimer un rendez-vous
    deleteRecord('rdv', 'id_rdv', $_GET['annulation'], './fichierclient.php');
}

// Vérification de la présence du paramètre 'suppcompte'
if (isset($_GET['suppcompte'])) {
    // Appel de la fonction deleteRecord pour supprimer un compte utilisateur
    deleteRecord('utilisateur', 'id', $_GET['suppcompte'], './index.php', 'utilisateur');
}

if (isset($_POST['rdv_id'])) {
    // Appel de la fonction deleteRecord pour supprimer un rendez-vous
    deleteRecord('rdv', 'jour_heure', $_POST['rdv_id'], './profil.php', 'rdv');
    unset($_SESSION['rdv']['jour_heure']);
} else {
    echo "Une erreur est survenue.";
}
