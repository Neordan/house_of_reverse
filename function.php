<?php 

/**

Génère le code HTML pour afficher une prestation avec un titre, une image et une description.
@param string $title Le titre de la prestation.
@param string $photoUrl L'URL de l'image de la prestation.
@param string $description La description de la prestation.
@return string Le code HTML pour afficher la prestation.
*/
function generatePresta($title, $photoUrl, $description) {
    $presta = '
        <h3 class="title">' . $title . '</h3>
        <div class="presta">
            <img src="' . $photoUrl . '" alt="' . $title . '">
            <p>' . $description . '</p>
            <i class="fa-solid fa-plus"></i>
        </div>
    ';

    return $presta;
};

//pour afficher les allergies dans les checkbox
function getAllergiesOptions() {
    return [
        'Aucune' => 'Aucune',
        'Produit chimique' => 'Produit chimique',
        'Acétone' => 'Acétone',
        'Latex' => 'Latex',
        'Autre' => 'Autre',
    ];
}