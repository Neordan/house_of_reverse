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

// Ce fichier traite les dates pour un système de réservation.

// Vérifie si la date de début est définie via GET
if (isset($_GET["start-date"])) {
    try {
        // Tente de créer un objet DateTime à partir de la date de début fournie
        $startDate = new DateTime($_GET["start-date"]);
    } catch (Exception | Error $e) {
        // Si la date fournie n'est pas valide, utilise la date actuelle par défaut
        $startDate = new DateTime();
    }
} else {
    // Si aucune date de début n'est fournie, utilise la date actuelle par défaut
    $startDate = new DateTime();
}

// Convertit l'objet DateTime en chaîne de caractères avec le format 'd-m-Y'
$stringDate = $startDate->format("d-m-Y");

// Déterminer le jour de la semaine pour faire partir l'agenda du lundi
$daysOfWeek = [
    "lundi",
    "mardi",
    "mercredi",
    "jeudi",
    "vendredi",
    "samedi",
    "dimanche",
];

// Obtient l'index du jour de la semaine (0 pour dimanche, 1 pour lundi, etc.)
$dayOfWeekIndex = $startDate->format("w");
// Calcule l'index pour trouver le lundi le plus proche
$mondayIndex = $dayOfWeekIndex === 0 ? 1 : -$dayOfWeekIndex + 1;

// Parcourt chaque jour de la semaine et calcule la date correspondante
foreach ($daysOfWeek as $index => $day) {
    // Calcule la différence en jours par rapport au lundi le plus proche
    $daysDiff = $index * 1 + $mondayIndex;
    // Ajoute la date correspondante au jour de la semaine dans le tableau $calendrier
    $calendrier[$day] = (new DateTime($stringDate))->modify("{$daysDiff} days");
}
