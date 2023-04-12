const productsCounter = document.querySelector(".stored-products__number");
const cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateStoredProductsCounter() {
    productsCounter.textContent = cart.length;
}

function addEventListenerCart() {
    const productCart = document.querySelectorAll(".product-element__cart");

    productCart.forEach((item) => {
        if (cart.includes(item.id)) {
            item.classList.add('product-element__cart--active');
        }
        
        item.addEventListener("click", function (e) {
            toggleProductInCart(e.target.id);
            item.classList.toggle('product-element__cart--active');
        });
    });
}

export function toggleProductInCart(id) {
    if (cart.includes(id)) {
        cart.splice(cart.indexOf(id), 1);
    } else {
        cart.push(id);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateStoredProductsCounter();
}

window.addEventListener("load", function () {
    addEventListenerCart();
    updateStoredProductsCounter();
});
