<?php

if (isset($_GET['annulation'])) {

    $annulation = $_GET['annulation'];
    $sql = "DELETE FROM rdv WHERE id_rdv=:id_rdv";

    require "./core/config.php";

    $result = $pdo->prepare($sql);
    $result->bindParam(':id_rdv', $annulation);

    if ($result->execute()) {
        header('Location: ./fichierclient.php');
    } else {
        echo "erreur";
    }
}
