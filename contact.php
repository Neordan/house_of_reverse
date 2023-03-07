<?php

require "./core/header.php";

?>

<h2>contact</h2>
<form action="./index.php" method="get">
    <div class="info">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="">
    </div>
    <div class="info">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom">
    </div>
    <div class="info">
        <label for="age">Âge :</label>
        <input type="text" name="age">
    </div>
    <div class="info">
        <label for="allergie">Allergies :</label>
        <select name="allergie" id="allergie">
            <option value="">-- Sélectionner votre choix --</option>
            <option value="">1</option>
            <option value="">2</option>
            <option value="">3</option>
        </select>
    </div>
    <div class="info">
        <label for="inspiration">Tes inspirations :</label>
        <input type="file" name="" id="inspiration">
    </div>
    <div class="info">
        <label for="ongle-img">Tes ongles :</label>
        <input type="file" name="" id="ongle-img">
    </div>
    <div class="info">
        <legend>Ongles rongés : </legend>
        <div class="choix-etat">
            <div class="bon">
                <input type="radio" name="ongle" id="oui">
                <label for="oui">Oui</label>
            </div>
            <div class="mauvais">
                <input type="radio" name="ongle" id="non">
                <label for="non">Non</label>
            </div>
        </div>
    </div>
    <div class="info">
        <label for="prestation">Prestation souhaité :</label>
        <select name="prestation" id="prestation">
            <option value="">-- Sélectionner votre choix --</option>
            <option value="chablons">Pose de chablons</option>
            <option value="gainage">Gainage</option>
            <option value="vsp">Vernis semi-permanent</option>
        </select>
    </div>
    <div class="info">
        <legend>Nail art:</legend>
        <div class="art">
            <div class="choix-art">
                <input type="checkbox" id="1" name="">
                <label for="1">1</label>
            </div>
            <div class="choix-art">
                <input type="checkbox" id="2" name="">
                <label for="2">2</label>
            </div>
            <div class="choix-art">
                <input type="checkbox" id="3" name="">
                <label for="3">3</label>
            </div>
            <div class="choix-art">
                <input type="checkbox" id="4" name="">
                <label for="4">4</label>
            </div>
        </div>
    </div>
    <div class="info">
        <label for="precision">Précisions:</label>
        <textarea name="precision" id="precision" rows="5" placeholder="Ton message .."></textarea>
    </div>
    <div class="info">
        <label for="dateRdv">Date du rendez-vous :</label>
    </div>
    <div class="info">
        <label for="heureRdv">Heure du rendez-vous :</label><select name="prestation" id="prestation">
            <option value="">-- Sélectionner votre choix --</option>
            <option value="">10h</option>
            <option value="">13h30</option>
            <option value="">16h30</option>
        </select>
    </div>
    <button type="submit" class="formulaire">envoyer</button>
</form>
<?php
require "./core/footer.php"
?>