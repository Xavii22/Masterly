const fileInput = document.querySelector('.editor__data__logo-input');
const image = document.querySelector('.editor__data__logo-image');

const loadImage = (file) => {
  const reader = new FileReader();
  reader.onload = () => image.src = reader.result;
  reader.readAsDataURL(file);
}

fileInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (file && file.type.startsWith('image/')) {
    loadImage(file);
  } else {
    console.log('El archivo seleccionado no es una imagen.');
  }
});