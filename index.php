<?php
$page_title = "Accueil";
require_once "./core/header.php";

?>

<h2>À propos de moi</h2>
<section class="description">
    <img src="./assets/img/img-desc.png" alt="Une image de la PO en train de travailler">
    <p>Je suis ravie de vous présenter mes services en matière de soins des ongles. Exercant ce métier
        depuis 2 ans, je suis passionnée par le soin et la beauté des ongles. Mon objectif est de vous offrir
        des soins de qualité pour que vous puissiez arborer des ongles sains et élégants.
        <br><br>
        Je propose une large gamme de services pour les mains et les pieds, allant du nettoyage des ongles à la
        pose
        de vernis, en passant par la manucure et la pédicure. Je suis aussi spécialisée dans les techniques
        d'extension d'ongles pour celleux qui désirent une longueur et une forme parfaite. Je travaille avec des
        produits
        de qualité supérieure pour garantir des résultats durables et sains.
    </p>
</section>
<section class="certificate">
    <h3>Mes certifications</h3>
    <div class="document">
        <img src="./assets/img/Certificats/MacroManucure-1.png" class="img" alt="Certificat macromanucure">
        <img src="./assets/img/Certificats/Certificat TOP NAIL MASTER NOM-1.png" class="img" alt="Certificat top nail master">
    </div>
</section>
<div class="client">
    <h3>Avis client</h3>
    <div class="avis">
        <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
        <img src="./assets/img/avis/avis.jpg" alt="Avis d'une cliente n°1">
        <img src="./assets/img/avis/avis2.jpg" alt="Avis d'une cliente n°2">
        <img src="./assets/img/avis/avis3.jpg" alt="Avis d'une cliente n°3">
        <img src="./assets/img/avis/avis4.jpg" alt="Avis d'une cliente n°4">
        <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

<?php
require_once "./core/footer.php";
?>