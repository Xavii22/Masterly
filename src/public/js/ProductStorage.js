function checkProductStored(id) {
    if (cart.find((item) => item === id))
        return cart.filter((item) => item !== id);

    cart.push(id);
    return cart;
}

function counterStoredProducts() {
    productsCounter.innerHTML = JSON.parse(localStorage.cart).length;
}


function storeProduct(id) {
    cart = checkProductStored(id);

    localStorage.setItem("cart", JSON.stringify(cart));
    
    counterStoredProducts();
}


let cart;
localStorage.cart ? (cart = JSON.parse(localStorage.cart)) : [];
const productsCounter = document.querySelector(".stored-products").firstChild;
counterStoredProducts();