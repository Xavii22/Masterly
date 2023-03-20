const productsCounter = document.querySelector(".stored-products").firstChild;
const cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateStoredProductsCounter() {
    productsCounter.textContent = cart.length;
}

function toggleProductInCart(id) {
    if (cart.includes(id)) {
        cart.splice(cart.indexOf(id), 1);
    } else {
        cart.push(id);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateStoredProductsCounter();
}

updateStoredProductsCounter();
