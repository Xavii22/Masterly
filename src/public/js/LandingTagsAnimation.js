const items = document.querySelectorAll('.product-landing');
let currentItemIndex = 0;

function showNextItem() {
  // hide current item
  items[currentItemIndex].style.left = '-100%';
  
  // show next item
  currentItemIndex = (currentItemIndex + 1) % items.length;
  items[currentItemIndex].style.left = '0';
}

document.querySelector('.arrow-button').addEventListener('click', showNextItem);
