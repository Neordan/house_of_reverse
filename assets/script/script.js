
// Menu hamburger

const menuToggle =  document.querySelector('.menu-toggle');
const menuBars = document.querySelectorAll('.menu-bar');
const menu = document.querySelector('nav');
const closeMenu = document.querySelector('.close-menu')

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('open')
  menu.style.display = 'flex';
})  
closeMenu.addEventListener('click', () => {
  menu.style.display = 'none';
})  




// si l'utilisateur clique sur aucune les autres sont désactivés \\

document.addEventListener("DOMContentLoaded", function() {
  // Sélectionnez la case à cocher "Aucune"
  const aucuneAllergie = document.getElementById('Aucune');
  
  // Sélectionnez toutes les cases à cocher "allergies[]"
  const allergiesCheckboxes = document.querySelectorAll('input[name="allergies[]"]');
  
  // Fonction pour activer / désactiver les cases à cocher autres que "Aucune" 
  function toggleAllergies(enabled) {
    allergiesCheckboxes.forEach(function(checkbox) {
      if (checkbox.id !== 'Aucune') {
        checkbox.disabled = !enabled;
                }
              });
            }
            
            // Ajoutez un écouteur d'événement 'click' pour la case à cocher "Aucune"
            aucuneAllergie.addEventListener('click', function() {
              toggleAllergies(!aucuneAllergie.checked);
            });
          
            // Ajoutez un écouteur d'événement 'click' pour les autres cases à cocher
            allergiesCheckboxes.forEach(function(checkbox) {
            if (checkbox.id !== 'Aucune') {
              checkbox.addEventListener('click', function() {
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
        });
        
// modal pour valider la suppression du compte
document.addEventListener("DOMContentLoaded", function() {
  const deleteAccountButton = document.getElementById("deleteAccountButton");
            
  deleteAccountButton.addEventListener("click", function(event) {
    const result = confirm("Êtes-vous sûr de vouloir supprimer votre compte?");
    if (!result) {
      event.preventDefault();
    }
  });
});
          




//zoom des certificats\\
const zoomImages = document.querySelectorAll('.img');
          
// boucle sur chaque image sélectionnée
zoomImages.forEach(image => {
  image.addEventListener('click', () => {
    // Si l'image est agrandie, on retire le zoom en supprimant la classe "zoomer"
    if (image.classList.contains('zoomer')) {
      image.classList.remove('zoomer');
    } else {
      // Sinon, on ajoute la classe "zoomer" pour agrandir l'image
      image.classList.add('zoomer');
    }
  });
});

// On ajoute un écouteur d'événement "click" au document et event : objet représnetant une action sur la page web
document.addEventListener('click', event => {
  // Si l'élément cliqué n'a pas la classe "zoomer"
  if (!event.target.classList.contains('zoomer')) {
    // boucle sur chaque image sélectionnée qui ont la classe
    zoomImages.forEach(image => {
      // On supprime la classe "zoomed" de chaque image
      image.classList.remove('zoomer');
    });
  }
});




//slide avis \\
let avisImages = document.querySelectorAll(".avis img");
let currentIndex = 0;
let prevButton = document.querySelector(".prev");
let nextButton = document.querySelector(".next");

function showSlide(index) {
    avisImages.forEach((img) => {
        img.style.display = "none";
    });

    if (index >= avisImages.length) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = avisImages.length - 1;
    }

    avisImages[currentIndex].style.display = "block";
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

// Change slide every 3 seconds
setInterval(() => {
    changeSlide(1);
}, 7000);





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




// verouiller les lundi et dimanche du calendrier mobile \\
document.getElementById('mobile-date').addEventListener('change', function() {
  const date = new Date(this.value);
  const day = date.getDay();
  const errorMessage = document.getElementById('date-error-message');
  
  if (day === 0 || day === 1) {
    errorMessage.style.display = 'block';
    this.setCustomValidity('Les rendez-vous ne sont pas disponibles les dimanches et les lundis.');
  } else {
    errorMessage.style.display = 'none';
    this.setCustomValidity('');
  }
});









