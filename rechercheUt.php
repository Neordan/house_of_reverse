<?php
require_once "./core/config.php";

// Vérifier si le terme de recherche 'q' est défini et non vide
if (isset($_GET['q']) && !empty($_GET['q'])) {
    if ($_GET["q"] == "") {
        $q = "%";
    } else {
        $q = "%" . $_GET["q"] . "%";
    }
    $searchTerm = trim($_GET['q']);

    // Rechercher les utilisateurs dont le nom ou le prénom correspondent au terme de recherche
    $sql = "SELECT * FROM utilisateur WHERE nom LIKE :search_term OR prenom LIKE :search_term";
    $query = $pdo->prepare($sql);
    $query->bindValue(':search_term', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>
