<?php

require "./core/header.php";

?>

<h2>Galerie</h2>
<div class="carousel">
    <div class="container">
        <input type="radio" name="slider" id="item-1" checked>
        <input type="radio" name="slider" id="item-2">
        <input type="radio" name="slider" id="item-3">
        <div class="cards">
            <label class="card" for="item-1" id="img-1">
                <img src="./assets/img/Photos/Ongle1.jpg" alt="song">
            </label>
            <label class="card" for="item-2" id="img-2">
                <img src="./assets/img/Photos/Ongle1.jpg" alt="song">
            </label>
            <label class="card" for="item-3" id="img-3">
                <img src="./assets/img/Photos/Ongle1.jpg" alt="song">
            </label>
        </div>
    </div>
</div>

<?php
require "./core/footer.php"
?>