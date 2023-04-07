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







