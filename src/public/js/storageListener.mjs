const productsCounter = document.querySelector(".stored-products__number");
const cart = JSON.parse(localStorage.getItem("cart")) || [];
const productCart = document.querySelectorAll(".cart-listener");

function updateStoredProductsCounter() {
    productsCounter.textContent = cart.length;
}

async function setLocalStorageToCartDatabase() {
    try {
        const response = await fetch("/home-init", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            }
        });

        const result = await response.json();
        localStorage.setItem("cart", JSON.stringify(result));

} catch (error) {
        console.error(error);
    }
}

async function submitProductIDToDatabase(data) {
    try {
        await fetch("/home", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(data),
        });
    } catch (error) {
        console.error(error);
    }
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
    submitProductIDToDatabase(id);
}

window.addEventListener("load", function () {
    setLocalStorageToCartDatabase();
    addEventListenerCart();
    updateStoredProductsCounter();
});
