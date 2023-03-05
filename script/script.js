//page login admin

const btnAdmin = document.querySelector('.fa-user');
const pageAdmin = document.querySelector('.login');
const closeAdmin = document.querySelector('.close-admin');

btnAdmin.addEventListener('click', ()=> {
  pageAdmin.style.display = 'flex';
})
closeAdmin.addEventListener('click', ()=> {
  pageAdmin.style.display = 'none';
  pageAdmin.style.left = '-700px';
  pageAdmin.style.transition = "10s" ;
})


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

// remonte la page de départ

const welcomeDiv = document.querySelector('.before');
const hideButton = document.querySelector('.btn-scroll');
const body = document.getElementsByTagName('body')[0];



hideButton.addEventListener('click', () => {
  welcomeDiv.classList.add('hide');
  body.style.overflowY = 'auto';
});

// // Vérifie si la div d'accueil est masquée dans le localStorage
// if (localStorage.getItem('hidebefore')) {
//   welcomeDiv.classList.add('hide');
// } else {
//   body.style.overflowY = 'hidden';
// }

// // Enregistre le masquage de la div d'accueil dans le localStorage
// hideButton.addEventListener('click', () => {
//   localStorage.setItem('hideWelcome', true);
// });

