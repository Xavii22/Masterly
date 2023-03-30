const categoryContainers = document.getElementsByClassName("category");

for (let i = 0; i < categoryContainers.length; i++) {
  const categoryLink = categoryContainers[i].querySelector(".category__content");

  categoryContainers[i].addEventListener('click', () => {
    categoryLink.click();
  });
}