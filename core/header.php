<?php
session_start(); 

if (empty($_SESSION['firstVisit'])) {
    $_SESSION['firstVisit'] = true;
    $showBefore = true;
} else {
    $showBefore = false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House of reverse</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./main.css">
    <script src="../script/script.js" defer></script>
</head>

<body>

    <!---- Partie de la page principale ------>
   
    <?php if ($showBefore) { ?>
		<div class="before">
        <div class="opacity">
            <div class="identity">
                <img src="./assets/img/Logo/IMG_0787.PNG" alt="House of reverse">
                <h1>house of reverse</h1>
            </div>
            <a class="btn-scroll">
                <i class="fa-solid fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <?php } 

// Supprime la variable de session 'visited' lorsqu'on quitte le site
// if (!isset($_COOKIE[session_name()])) {
//     session_unset();
//     session_destroy();
// }
// ?>

    <!------ Partie du header ------->

    <header>
        <i class="fa-solid fa-user"></i>
        <?php require "./login.php";?>
        <div class="menu-toggle">
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
            <span class="menu-bar"></span>
        </div>
        <nav id="navigation">
            <i class="fa-solid fa-xmark close-menu"></i>
            <ul>
                <li><a href="./prestations.php">Prestations</a></li>
                <li><a href="./galerie.php">Galerie</a></li>
                <li><a href="./tarifs.php">Tarifs</a></li>
                <li><a href="./contact.php">Rendez-vous</a></li>
            </ul>
            <a href="./index.php"><i class="fa-solid fa-house"></i></a>
        </nav>
    </header>
    <div class="logo">
        <h1>house of reverse</h1>
        <img src="./assets/img/Logo1.PNG" alt="Logo de House of reverse">
    </div>
    <main>