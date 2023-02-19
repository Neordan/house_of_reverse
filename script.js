// remonte la page de départ

document.addEventListener('DOMContentLoaded', () => {
  const before = document.querySelector('.before');
  const scrollButton = document.querySelector('.btn-scroll');
  const links = document.querySelectorAll('a');

  scrollButton.addEventListener('click', () => {
    before.style.display = 'none';
  });

  links.forEach(link => {
    link.addEventListener('click', event => {
      const href = link.getAttribute('href');
      if (href === './index.html') {
        before.style.display = 'none';
      } else  {
        before.style.display = 'none';

      }
    });
  });
});






// Menu hamburger

const menuToggle =  document.querySelector('.menu-toggle');
const menuBars = document.querySelectorAll('.menu-bar');
const menu = document.querySelector('nav');

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('open');
  menuBars.forEach(bar => bar.classList.toggle('open'));
  menu.classList.toggle('nav-cached');
})