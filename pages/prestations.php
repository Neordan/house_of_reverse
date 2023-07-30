<?php
$page_title = "Prestations";
require_once "../core/header.php";
require "../actions/function.php";
?>

<h2>mes prestations</h2>

<?= generatePresta('Pose de chablons', '../assets/img/Photos/chablons.jpg', 'La pose de chablons est une technique sur-mesure pour obtenir une surface lisse et régulière sur les ongles avant l\'application de gel. Elle permet de rallonger les ongles en une séance afin de corriger leur forme naturelle. Généralement faits en papier, qui sont placés sous l\'ongle pour créer une architecture solide et uniforme.<br><br>
Autrement-dit si tu veux des ongles plus longs cette prestation est faite pour toi !') ?>

<?= generatePresta('Renforcement VSP', '../assets/img/Photos/IMG-1430.JPG', 'Le renforcement permet de conserver les ongles naturels en leur donnant une couche de protection supplémentaire. Il aide à prévenir l\'écaillage et la casse, ce qui est particulièrement avantageux pour ceux et celles qui ont des ongles fragiles ou qui ont du mal à faire pousser leurs ongles. 
<br><br>
Il existe une grande variété de couleurs et de finitions, ce qui permet de créer des designs et des styles personnalisés. 
Que tu recherches un look discret et naturel ou des ongles audacieux et accrocheurs, tu trouveras certainement une teinte qui correspond à tes goûts et à ton style. 
<br><br>
En résumé, le vernis semi-permanent est une technique polyvalente et durable qui offre une longue tenue sans nécessiter de retouches fréquentes pour ceux et celles qui souhaitent une manucure impeccable qui dure plusieurs semaines.') ?>

<?= generatePresta('Remplissage', '../assets/img/Photos/IMG-1431.JPG', 'Le remplissage est une technique utilisée pour entretenir et prolonger la durée de vie d\'une pose. Lorsque les ongles naturels poussent, la matière placée 3 voire 4 semaines plus tôt créer un poids sur le bord libre de l\'ongle, ce qui peut rendre la pose d\'ongles inesthétique et entraîner des risques d\'endommagement de l\'ongle naturel.
<br><br>
Le remplissage permet donc de combler cet espace en ajoutant de la matière sur l\'ongle naturel qui a poussé. 
<br><br>
Bref, le remplissage en prothésie ongulaire est une technique indispensable pour maintenir la beauté et la solidité d\'une pose.') ?>

<?= generatePresta('Gainage', '../assets/img/Photos/IMG-1432.JPG', 'Le gainage offre la possibilité de poser de la matière directement sur l’ongle naturel.
<br><br> 
À l’inverse d’un renforcement ici le but n’étant pas de conserver sa longueur naturelle mais de l’utiliser comme extension pour pouvoir le supprimer par la suite afin de ne pas créer de décollements qui peuvent causer infiltrations et casses…
<br><br> 
Il est recommandé pour celles et ceux qui veulent des ongles longs sans passer par la pose de chablons à la différence que ce sera possible qu’en plusieurs remplissages.') ?>

<?= generatePresta('Pédicure', '../assets/img/Photos/IMG-1429 (1).JPG', 'La pédicure, un soin incontournable pour des pieds heureux et en bonne santé ! 
<br><br>
Prendre soin de ses pieds est essentiel pour se sentir bien dans sa peau au quotidien. 
<br><br>
Lors d\'une séance de pédicure, tes pieds sont choyés, nettoyés et chouchoutés pour éliminer les peaux mortes et hydrate la peau.
L\'application de vernis (semi-permanent) apporte la touche finale pour des pieds élégants et soignés durant plus de 4 semaines.') ?>


<?php require_once "../core/footer.php"; ?>