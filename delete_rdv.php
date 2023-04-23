<?php
session_start();
require_once "./core/config.php";

// Vérifier si l'ID de l'utilisateur est défini dans l'URL
if (isset($_GET['supprdv']) && !empty($_GET['supprdv'])) {
    $userId = intval($_GET['supprdv']);

    // Supprimer le rendez-vous pour l'utilisateur correspondant
    $sql = "DELETE FROM rdv WHERE id_utilisateur = :utilisateur_id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':utilisateur_id', $userId, PDO::PARAM_INT);
    $query->execute();

    // Mettre à jour la session en supprimant le rendez-vous
    unset($_SESSION['rdv']);

    // Rediriger vers la page de profil avec un message de succès
    $_SESSION['success'] = "Votre rendez-vous a été supprimé avec succès.";
    header("Location: profil.php");
    exit();
} else {
    // Rediriger vers la page de profil avec un message d'erreur si l'ID de l'utilisateur est manquant
    $_SESSION['error'] = "Une erreur s'est produite. Impossible de supprimer le rendez-vous.";
    header("Location: profil.php");
    exit();
}
?>
