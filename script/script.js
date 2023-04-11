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

//page login admin

// const btnAdmin = document.querySelector('.fa-user');
// const pageAdmin = document.querySelector('.login');
// const closeAdmin = document.querySelector('.close-admin');

// btnAdmin.addEventListener('click', ()=> {
//   pageAdmin.style.display = 'flex';
// })  
// closeAdmin.addEventListener('click', ()=> {
//   pageAdmin.style.display = 'none';
//   pageAdmin.style.left = '-700px';
//   pageAdmin.style.transition = "10s" ;
// })  

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






