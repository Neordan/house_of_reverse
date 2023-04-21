<?php
session_start();

require "./core/config.php";

if (isset($_SESSION["utilisateur"]["id"])) {
    $user_id = $_SESSION["utilisateur"]["id"];

    // Suppression du rendez-vous de la base de données en fonction de l'ID utilisateur
    $sql = "DELETE FROM rdv WHERE id_utilisateur = :user_id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($query->execute()) {
        // Suppression des informations du rendez-vous de la session
        unset($_SESSION['jour_heure']);

        // Redirection vers la page profil
        header("Location: ./profil.php");
    } else {
        echo "Une erreur s'est produite lors de la suppression du rendez-vous.";
    }
} else {
    // Redirection vers la page profil si aucun ID d'utilisateur n'est fourni
    header("Location: ./profil.php");
}
