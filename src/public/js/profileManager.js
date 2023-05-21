const logout = document.querySelector('.editor__data-logout');

logout.addEventListener('click', () => {
  localStorage.removeItem('cart');
});

