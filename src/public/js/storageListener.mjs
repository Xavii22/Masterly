const productsCounter = document.querySelector(".stored-products__number");
const cart = JSON.parse(localStorage.getItem("cart")) || [];
const productCart = document.querySelectorAll(".cart-listener");

function updateStoredProductsCounter() {
    productsCounter.textContent = cart.length;
}

function addEventListenerCart() {

    productCart.forEach((item) => {
        if (cart.includes(item.id)) {
            item.classList.add('chosen-cart');
        }
        
        item.addEventListener("click", function (e) {
            toggleProductInCart(e.target.closest(".cart-listener").id);
            item.classList.toggle('chosen-cart');
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
