<?php
session_start();

// Fonction générique pour supprimer un enregistrement dans une table
function delete($table, $idChamp, $idValue, $redirectUrl, $sessionKey = null) {
    require_once "../core/config.php";

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

// Vérification de la présence du paramètre 'annulation' en POST
if (isset($_POST['annulation'])) {
    // Appel de la fonction delete pour supprimer un rendez-vous
    delete('rdv', 'id_rdv', $_POST['annulation'], '../pages/fichierclient.php');
}

// Vérification de la présence du paramètre 'suppcompte' en POST
if (isset($_POST['suppcompte'])) {
    // Appel de la fonction delete pour supprimer un compte utilisateur
    delete('utilisateur', 'id', $_POST['suppcompte'], '../index.php', 'utilisateur');
}

if (isset($_POST['rdv_id'])) {
    // Appel de la fonction delete pour supprimer un rendez-vous
    delete('rdv', 'jour_heure', $_POST['rdv_id'], '../pages/profil.php', 'rdv');
    unset($_SESSION['rdv']['jour_heure']);
} else {
    echo "Une erreur est survenue.";
}