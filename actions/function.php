<?php

/**
Génère le code HTML pour afficher une prestation avec un titre, une image et une description.
@param string $title Le titre de la prestation.
@param string $photoUrl L'URL de l'image de la prestation.
@param string $description La description de la prestation.
@return string Le code HTML pour afficher la prestation.
 */
function generatePresta($title, $photoUrl, $description)
{
    $presta = '
    <div class="presta">
            <h3>' . $title . '</h3>
            <img src="' . $photoUrl . '" alt="' . $title . '">
            <p class="descriptionpresta">' . $description . '</p>
            <i class="fa-solid fa-plus"></i>
            <i class="fa-solid fa-minus"></i>
        </div>
    ';

    return $presta;
};

//pour afficher les allergies dans les checkbox
function getAllergiesOptions()
{
    return [
        'Aucune' => 'Aucune',
        'Produit chimique' => 'Produit chimique',
        'Acétone' => 'Acétone',
        'Latex' => 'Latex',
        'Autre' => 'Autre',
    ];
}

/**
 * Calcule l'âge à partir de la date de naissance.
 *
 * @param string $birthDate La date de naissance au format YYYY-MM-DD.
 * @return int L'âge en années.
 */

function calculateAge($birthDate)
{
    $today = new DateTime(); // Date actuelle
    $birthdate = new DateTime($birthDate); // Date de naissance
    $interval = $birthdate->diff($today); // Calcul de l'âge
    $age = $interval->y; // Années
    return $age;
}

/**
 * Formate une date (avec l'heure) en français.
 *
 * @param string $dateTexte La date au format texte à formater.
 * @return string La date formatée en français.
 */
function formatDateHeureEnFrancais($dateTexte) {
    $date = new DateTime($dateTexte);
    
    // Configuration de l'objet IntlDateFormatter pour le format français
    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
    $formattedDate = $formatter->format($date);

    return $formattedDate;
}
