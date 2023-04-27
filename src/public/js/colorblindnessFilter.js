const dropdown = document.querySelectorAll(".dropdown-content__value");
const images = document.querySelectorAll(".product-element__image");

function selectColorblindnessClasses(type) {
    images.forEach((image) => {
        image.className = `product-element__image product-element__image--${type}`;
    });
}

dropdown.forEach((element) => {
    element.addEventListener("click", function (e) {
        selectColorblindnessClasses(e.target.textContent.toLowerCase());
    });
});
