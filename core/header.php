<?php
session_start();
// Fuseau horaire par défaut du serveur
date_default_timezone_set("Europe/Paris");

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="House of Reverse est un site de rendez-vous et d'information pour les services de prothésie ongulaire. Découvrez nos prestations, galerie et tarifs, et prenez rendez-vous pour vos besoins de beauté.">
    <link rel="icon" type="image/png" href="../assets/img/Logo/Logoicon.jpg">
    <meta name="keywords" content="prothésie ongulaire, rendez-vous, prestations, tarifs, galerie, beauté">
    <meta property="og:title" content="House of reverse - <?= $page_title ?>">
    <meta property="og:description" content="House of Reverse est un site de rendez-vous et d'information pour les services de prothésie ongulaire. Découvrez nos prestations, galerie et tarifs, et prenez rendez-vous pour vos besoins de beauté.">
    <meta property="og:image" content="../assets/img/Logo/Logoicon.jpg">
    <title>House of reverse - <?= $page_title ?> </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/main.css">

    <script src="../assets/js/script.js" defer></script>
</head>

<body>

    <!------ Partie du header ------->

    <header>
        <div class="menu">
            <?php if (isset($_SESSION['utilisateur'])) {  ?>
                <a class="logout" href='../actions/logout.php'>Déconnexion</a>
            <?php } else { ?>
                <a class="logout" href='../pages/login.php'>Connexion</a>
            <?php } ?>

            <div class="menu-toggle">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </div>
            <nav class="navigation" id="navigation">
                <i class="fa-solid fa-xmark close-menu"></i>
                <ul>
                    <li><a href="../pages/prestations.php">Prestations</a></li>
                    <li><a href="../pages/galerie.php">Galerie</a></li>
                    <li><a href="../pages/tarifs.php">Tarifs</a></li>
                    <?php if (!empty($_SESSION['utilisateur'])) {  ?>
                        <li><a href='../pages/profil.php'>Profil</a></li>
                        <?php if (!isset($_SESSION['rdv']['jour_heure'])) { ?>
                            <li><a href='../pages/contact.php'>RDV</a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <a href="./index.php"><i class="fa-solid fa-house"></i></a>
            </nav>
            <nav class="navordi <?= empty($_SESSION['utilisateur']) ? 'navordi-not-connected' : 'navordi-connected'; ?>">
                <ul>
                    <li><a href="../index.php">Accueil</a></li>
                    <li><a href="../pages/prestations.php">Prestations</a></li>
                    <li><a href="../pages/galerie.php">Galerie</a></li>
                    <li><a href="../pages/tarifs.php">Tarifs</a></li>
                    <?php if (isset($_SESSION['utilisateur'])) : ?>
                        <?php if ($_SESSION['utilisateur']['role'] == 'utilisateur') : ?>
                            <li><a href='../pages/profil.php'>Profil</a></li>
                            <?php if (!isset($_SESSION['rdv']['jour_heure'])) { ?>
                                <li><a href='../pages/contact.php'>RDV</a></li>
                            <?php } ?>
                        <?php elseif ($_SESSION['utilisateur']['role'] == 'admin') : ?>
                            <li><a href='../pages/fichierClient.php'>Fichier client</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="logo">
            <h1>house of reverse</h1>
            <img src="../assets/img/Logo1.PNG" alt="Logo de House of reverse">
        </div>
    </header>
    <main>