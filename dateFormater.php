<?php

// Objet permettant de formater une date en français
$dateFormater = new IntlDateFormatter(
    'fr-FR',                    // Locale
    IntlDateFormatter::FULL,    // type de date
    IntlDateFormatter::FULL,    // type de temps
    'Europe/Paris',             // fuseau horaire
    IntlDateFormatter::GREGORIAN, // Calendrier
    "EEEE dd MMMM"         // format de la date
);

// Objet permettant de formater une date en français en toute lettre
$dateFormaterAvecHeure = new IntlDateFormatter(
    'fr-FR',                    
    IntlDateFormatter::LONG,    
    IntlDateFormatter::SHORT,   
    'Europe/Paris',            
    IntlDateFormatter::GREGORIAN, 
    "EEEE d MMMM yyyy 'à' HH:mm" 
);
?>