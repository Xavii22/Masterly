let slideIndex = 1;
showDivs(slideIndex);

const plusDivs = (n) => showDivs((slideIndex += n));

function showDivs(n) {
    const images = document.getElementsByClassName("image__slider-image");
    slideIndex = n > images.length ? 1 : n < 1 ? images.length : n;
    for (let i = 0; i < images.length; i++) {
        images[i].style.display = "none";
    }
    images[slideIndex - 1].style.display = "block";
}
