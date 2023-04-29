<?php
session_start();
// Fuseau horaire par défaut du serveur
date_default_timezone_set("Europe/Paris");
require "./dateFormater.php";
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House of reverse</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/main.css">
 

    <script src="../assets/script/script.js" defer></script>
</head>

<body>

    <!------ Partie du header ------->

    <header>
        <div class="menu">
            <?php if (isset($_SESSION['utilisateur'])) {  ?>
                <a class="logout" href='./logout.php'>Déconnexion</a>
            <?php } else { ?>
                <a class="logout" href='../login.php'>Connexion</a>
            <?php } ?>

            <div class="menu-toggle">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </div>
            <nav class="navigation" id="navigation">
                <i class="fa-solid fa-xmark close-menu"></i>
                <ul>
                    <li><a href="./prestations.php">Prestations</a></li>
                    <li><a href="./galerie.php">Galerie</a></li>
                    <li><a href="./tarifs.php">Tarifs</a></li>
                    <?php if (!empty($_SESSION['utilisateur'])) {  ?>
                        <li><a href='./profil.php'>Profil</a></li>
                        <li><a href='./contact.php'>Rendez-vous</a></li>
                    <?php } ?>
                </ul>
                <a href="./index.php"><i class="fa-solid fa-house"></i></a>
            </nav>
            <nav class="navordi <?= empty($_SESSION['utilisateur']) ? 'navordi-not-connected' : 'navordi-connected'; ?>">
            <ul>
                <li><a href="./index.php">Accueil</a></li>
                <li><a href="./prestations.php">Prestations</a></li>
                <li><a href="./galerie.php">Galerie</a></li>
                <li><a href="./tarifs.php">Tarifs</a></li>

                <?php if (isset($_SESSION['utilisateur'])) : ?>
                    <?php if ($_SESSION['utilisateur']['role'] == 'utilisateur') : ?>
                        <li><a href='./profil.php'>Profil</a></li>
                        <li><a href='./contact.php'>Rendez-vous</a></li>
                    <?php elseif ($_SESSION['utilisateur']['role'] == 'admin') : ?>
                        <li><a href='./fichierClient.php'>Fichier client</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
        </div>
        <div class="logo">
            <h1>house of reverse</h1>
            <img src="./assets/img/Logo1.PNG" alt="Logo de House of reverse">
        </div>
    </header>
    <main>