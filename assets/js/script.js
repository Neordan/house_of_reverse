// modification profil
document.addEventListener('DOMContentLoaded', function() {
  const btnEditProfile = document.getElementById('editProfileButton');
  const btnSaveChanges = document.getElementById('saveProfileButton');
  const allergiesInput = document.getElementById('allergies');
  const ageInput = document.getElementById('age');

  btnEditProfile.addEventListener('click', function() {
    // Activer les champs "Prénom", "Nom" et "Email" seulement
    document.getElementById('prenom').disabled = false;
    document.getElementById('nom').disabled = false;
    document.getElementById('email').disabled = false;

    // Ajouter la classe "editable" aux éléments modifiables
    document.getElementById('prenom').classList.add('editable');
    document.getElementById('nom').classList.add('editable');
    document.getElementById('email').classList.add('editable');

    // Supprimer la classe "editable" des champs "Allergies" et "Âge"
    allergiesInput.classList.add('desable');
    ageInput.classList.add('desable');

    btnSaveChanges.style.display = 'block';
    btnEditProfile.style.display = 'none';
  });

  btnSaveChanges.addEventListener('click', function() {
    // Désactiver les champs "Prénom", "Nom" et "Email" lorsque le formulaire est soumis
    document.getElementById('prenom').disabled = true;
    document.getElementById('nom').disabled = true;
    document.getElementById('email').disabled = true;

    document.getElementById('prenom').classList.remove('editable');
    document.getElementById('nom').classList.remove('editable');
    document.getElementById('email').classList.remove('editable');

    // Ajouter la classe "editable" aux champs "Allergies" et "Âge" pour les griser
    allergiesInput.classList.remove('desable');
    ageInput.classList.remove('desable');

    btnSaveChanges.style.display = 'none';
    btnEditProfile.style.display = 'block';
  });
});



// Menu hamburger

const menuToggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('nav');
const closeMenu = document.querySelector('.close-menu');

menuToggle.addEventListener('click', () => {
  menu.style.display = 'flex';
})
closeMenu.addEventListener('click', () => {
  menu.style.display = 'none';
})


// si l'utilisateur clique sur aucune les autres sont désactivés \\

document.addEventListener("DOMContentLoaded", () => {
  // Sélectionnez la case à cocher "Aucune"
  const aucuneAllergie = document.getElementById('Aucune');

  // Sélectionnez toutes les cases à cocher "allergies[]"
  const allergiesCheckboxes = document.querySelectorAll('input[name="allergies[]"]');

  // Fonction pour activer / désactiver les cases à cocher autres que "Aucune" 
  function toggleAllergies(enabled) {
    allergiesCheckboxes.forEach(function (checkbox) {
      if (checkbox.id !== 'Aucune') {
        checkbox.disabled = !enabled;
      }
    });
  }

  // Ajoutez un écouteur d'événement 'click' pour la case à cocher "Aucune"
  if (aucuneAllergie) {
    aucuneAllergie.addEventListener('click', () => {
      toggleAllergies(!aucuneAllergie.checked);
    });

    // Ajoutez un écouteur d'événement 'click' pour les autres cases à cocher
    allergiesCheckboxes.forEach(function (checkbox) {
      if (checkbox.id !== 'Aucune') {
        checkbox.addEventListener('click', () => {
          if (checkbox.checked) {
            aucuneAllergie.checked = false;
          }
        });
      }
    });

    // Désactivez les cases à cocher autres que "Aucune" si "Aucune" est coché au chargement de la page
    if (aucuneAllergie.checked) {
      toggleAllergies(false);
    }
  }
});

// modal pour valider la suppression du compte
document.addEventListener("DOMContentLoaded", () => {
  const deleteAccountButton = document.getElementById("deleteAccountButton");

  if (deleteAccountButton) {
    deleteAccountButton.addEventListener("click", (e) => {
      const result = confirm("Êtes-vous sûr de vouloir supprimer votre compte?");
      if (!result) {
        e.preventDefault();
      }
    });
  }
});

// Caroussel des avis 

document.addEventListener("DOMContentLoaded", () => {
  let avisImages = document.querySelectorAll(".avis img");
  let currentIndex = 0;
  let prevButton = document.querySelector(".prev");
  let nextButton = document.querySelector(".next");

  if (avisImages.length > 0 && prevButton && nextButton) {
    function showSlide(index) {
      avisImages.forEach((img) => {
        img.style.display = "none";
      });

      if (index >= avisImages.length) {
        currentIndex = 0;
      } else if (index < 0) {
        currentIndex = avisImages.length - 1;
      }

      if (avisImages[currentIndex]) {
        avisImages[currentIndex].style.display = "block";
      }
    }

    function changeSlide(step) {
      currentIndex += step;
      showSlide(currentIndex);
    }

    showSlide(currentIndex);

    prevButton.addEventListener("click", () => {
      changeSlide(-1);
    });

    nextButton.addEventListener("click", () => {
      changeSlide(1);
    });

    // Change de slide toutes les 5 secondes
    setInterval(() => {
      changeSlide(1);
    }, 5000);
  }
});




//pour l'affichage des description sous les image des prestations en fonction du bouton appuyé \\

// Fonction pour initialiser les gestionnaires d'événements pour les icônes plus et moins
function initToggleDescription() {
  // Sélectionner tous les éléments .fa-plus, .fa-minus et .descriptionpresta
  const plusIcons = document.querySelectorAll('.fa-plus');
  const minusIcons = document.querySelectorAll('.fa-minus');
  const descriptions = document.querySelectorAll('.descriptionpresta');

  // Attacher les gestionnaires d'événements aux icônes plus
  plusIcons.forEach((plus, index) => {
    plus.addEventListener('click', () => {
      // Lorsque l'icône plus est cliquée, étendre la description correspondante
      descriptions[index].style.setProperty('-webkit-line-clamp', '150');
      // Cacher l'icône plus
      plus.style.display = 'none';
      // Afficher l'icône moins
      minusIcons[index].style.display = 'flex';
    });
  });

  // Attacher les gestionnaires d'événements aux icônes moins
  minusIcons.forEach((minus, index) => {
    minus.addEventListener('click', () => {
      // Lorsque l'icône moins est cliquée, réduire la description correspondante
      descriptions[index].style.removeProperty('-webkit-line-clamp');
      // Afficher l'icône plus
      plusIcons[index].style.display = 'flex';
      // Cacher l'icône moins
      minus.style.display = 'none';
    });
  });
}
 // Fonction pour désactiver les lundis et dimanches dans le calendrier mobile
 function disableMondaysAndSundays(date) {
  // Récupérer le jour de la semaine (0: dimanche, 1: lundi, ..., 6: samedi)
  const dayOfWeek = date.getDay();

  // Désactiver les lundis (1) et dimanches (0)
  return [1, 0].indexOf(dayOfWeek) === -1;
}

// Initialiser le calendrier mobile
document.addEventListener("DOMContentLoaded", function () {
  const mobileDateInput = document.getElementById("mobile-date");

  // Définir la date minimale (aujourd'hui)
  const today = new Date();
  mobileDateInput.min = today.toISOString().split("T")[0];

  // Désactiver les lundis et dimanches dans le calendrier
  mobileDateInput.addEventListener("input", function () {
    const selectedDate = new Date(mobileDateInput.value);
    if (!disableMondaysAndSundays(selectedDate)) {
      mobileDateInput.value = ""; // Réinitialiser la valeur du champ si le jour sélectionné est un lundi ou un dimanche
    }
  });
});

