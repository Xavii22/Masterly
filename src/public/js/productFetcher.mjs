import {toggleProductInCart} from './storageListener.mjs';

export function modifyProductsPrice(products) {
    const price = document.querySelector(".cart__summary-price-number");

    let totalPrice = products.length > 0 ? 
        products.map((product) => product.price).reduce((acc, amount) => acc + amount) : 0;

    price.textContent = `${totalPrice} €`;
}

function modifyProductsCounter(totalProducts) {
    const productsCounter = document.querySelector(".cart__header-products span");

    productsCounter.textContent = totalProducts;
}

function createLink(url, content) {
    const link = document.createElement("a");
    link.classList.add(`${content.className}-link`);
    link.href = url;
    link.appendChild(content);
    return link;
}

function findMainImage(images) {
    for (const image of images.data) {
      if (image.main) {
        return image.path;
      }
    }
  }

async function fetchProductImage(productId) {
    try {
        const response = await fetch(`http://localhost:8080/api/products/${productId}/images`);
        const images = await response.json();

        return findMainImage(images);

    } catch (error) {
        console.error(error);
    } finally {
        const spinner = document.querySelector(".cart__product-spinner");
        const cart = document.querySelector(".cart");
        spinner.classList.add('cart__product-spinner--disable');
        cart.classList.add('cart--enable');
    }
}

function createImage(src, alt) {
    const img = document.createElement("img");
    img.classList.add(`product-item__image-${alt}`);
    img.src = src;
    img.alt = alt;
    return img;
}

function createHeading(className, text) {
    const heading = document.createElement("h1");
    heading.classList.add(className);
    heading.textContent = text;
    return heading;
}

function createPrice(className, text) {
    const h3 = document.createElement("h3");
    h3.classList.add(className);
    h3.textContent = `${text}€`;
    return h3;
}

function addEventListenerTrash(trash, products) {
    trash.addEventListener("click", function (e) {
        toggleProductInCart(e.target.closest(".product-item").id);
        e.target.closest(".product-item").remove();

        products = products.filter(item => localStorage.getItem("cart").includes(item.id));
        modifyProductsPrice(products);
        modifyProductsCounter(products.length);
    });
}

async function createProductArticle(item, products) {
    const article = document.createElement("article");
    article.classList.add("product-item");
    article.id = item.id;
  
    const imageUrl = await fetchProductImage(item.id);
    const imgLink = createLink(`/product/${item.id}`, createImage(imageUrl, "product"));
    const nameLink = createLink(`/product/${item.id}`, createHeading("product-item__name", item.name));
    const price = createPrice("product-item__price", item.price);
    const trash = createImage("../images/trash.png", "trash");
    addEventListenerTrash(trash, products);
  
    article.append(imgLink, nameLink, price, trash);
  
    return article;
}

async function createCartContent(products) {
    const productList = document.querySelector(".cart__product-list");
    for (const item of products) {
        const article = await createProductArticle(item, products);
        productList.appendChild(article);
    }

    modifyProductsCounter(products.length);

    modifyProductsPrice(products);
}

async function fetchStorageProducts() {
    try {
        const data = JSON.parse(localStorage.getItem("cart"));
        const response = await fetch("/cart", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(data),
        });
        const products = await response.json();

        createCartContent(products);
    } catch (error) {
        console.error(error);
    }
}

window.addEventListener("load", fetchStorageProducts());
