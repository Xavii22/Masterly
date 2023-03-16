const productsCounter = document.querySelector('.stored-products');
let cart;
localStorage.cart ? cart = JSON.parse(localStorage.cart): [];

function checkProductStored(id) {
    if (cart.find((item) => item === id))
        return cart.filter((item) => item !== id);

    cart.push(id);
    return cart;
}

function counterStoredProducts() {
    
    return;
}

function storeProduct(id) {
    cart = checkProductStored(id);

    localStorage.setItem("cart", JSON.stringify(cart));

    counterStoredProducts();
}
