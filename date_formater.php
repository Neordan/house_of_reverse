<?php

// Objet permettant de formater une date en français
$dateFormater = new IntlDateFormatter(
    'fr-FR',                    // Locale
    IntlDateFormatter::FULL,    // Date type
    IntlDateFormatter::FULL,    // Time type
    'Europe/Paris',             // Timezone
    IntlDateFormatter::GREGORIAN, // Calendrier
    "EEEE dd MMMM yyyy"         // Pattern
);
?>