const header = document.querySelector('.header');
let lastScrollTop = 0;

window.addEventListener('scroll', () => {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    header.classList.add('headder--hidden');
  } else {
    header.classList.remove('headder--hidden');
  }
  lastScrollTop = scrollTop;
});