<?php

$session_timeout = 3600; // 30 minutes (30 * 60 seconds)
session_set_cookie_params($session_timeout);
session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    // La session a expiré, détruire la session et rediriger vers la page de connexion
    session_unset();
    session_destroy();
    header('Location: ../login.php');
    exit;
}

// Fuseau horaire par défaut du serveur
date_default_timezone_set("Europe/Paris");
ob_start(); // Activer la mise en mémoire tampon de sortie
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="House of Reverse est un site de rendez-vous et d'information pour les services de prothésie ongulaire. Découvrez nos prestations, galerie et tarifs, et prenez rendez-vous pour vos besoins de beauté.">
    <link rel="icon" type="image/png" href="../assets/img/Logo/Logoicon.jpg">
    <meta name="keywords" content="prothésie ongulaire, ongle, beauté">
    <meta property="og:title" content="House of reverse - <?= $page_title ?>">
    <meta property="og:description" content="House of Reverse est un site de rendez-vous et d'information pour les services de prothésie ongulaire. Découvrez nos prestations, galerie et tarifs, et prenez rendez-vous pour vos besoins de beauté.">
    <meta property="og:image" content="../assets/img/Logo/Logoicon.jpg">
    <title>House of reverse - <?= $page_title ?> </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/main.css">

    <script src="../assets/js/script.js" defer></script>
    <script src="../assets/js/validate.js" defer></script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcdrEknAAAAAOGZX9njn_jn-1DqJWLzdGS8CEvF"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

    <!------ Partie du header ------->

    <header id="top">
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
                <a href="../index.php"><i class="fa-solid fa-house"></i></a>
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