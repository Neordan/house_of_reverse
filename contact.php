<?php

require "./core/header.php";

?>

<h2>contact</h2>
<form action="./index.php" method="post" >
    <div class="info">
        <label for="inspiration">Tes inspirations :</label>
        <input type="file" name="" id="inspiration">
    </div>
    <div class="info">
        <label for="ongle-img">Tes ongles :</label>
        <input type="file" name="" id="ongle-img">
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
    <label for="date">Date :</label>
  <input type="text" name="date" id="date">

 
    </div>
    <div class="info">
    <label for="heure">Heure :</label>
  <input type="time" name="heure" id="heure">
    </div>
    <button type="submit" class="formulaire">envoyer</button>
</form>
<script>
  $(function() {
    $("#date").datepicker();
  });
</script>
<?php
require "./core/footer.php"
?>