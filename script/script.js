
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

//slide avis
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
}, 3000);

//modification du profil

const form = document.querySelector('form');
const inputs = form.querySelectorAll('input[type="text"]');
const btnModifier = form.querySelector('button');
const btnEnregistrer = document.createElement('button');
btnEnregistrer.innerText = 'Enregistrer';
btnEnregistrer.style.display = 'none';
btnEnregistrer.type = 'submit';
form.appendChild(btnEnregistrer);

btnModifier.addEventListener('click', function() {
  inputs.forEach(input => input.disabled = false);
  btnModifier.style.display = 'none';
  btnEnregistrer.style.display = 'block';
  for (var i = 0; i < inputs.length; i++) {
    inputs[i].removeAttribute("disabled");
  }
  document.getElementById("btnSave").removeAttribute("disabled");
});

//pour l'affichage des description sous les image des prestations en fonction du bouton appuyé.

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

// modal pour valider la suppression du compte
document.addEventListener("DOMContentLoaded", function() {3
  const deleteAccountButton = document.getElementById("deleteAccountButton");
  
  deleteAccountButton.addEventListener("click", function(event) {
    const result = confirm("Êtes-vous sûr de vouloir supprimer votre compte?");
    if (!result) {
      event.preventDefault();
    }
  });
});

/* JavaScript */






