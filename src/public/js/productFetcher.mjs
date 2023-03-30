import {addEventListenerTrash} from './storageListener.mjs';

export function modifyProductsPrice(products) {
    const price = document.querySelector(".cart__summary-price span");

    price.textContent = products
        .map((product) => product.price)
        .reduce((acc, amount) => acc + amount);
        console.log('hola');
}

function createProductsCounter(counter, totalProducts) {
    counter.textContent = totalProducts;
}

function createLink(url, content) {
    const link = document.createElement("a");
    link.classList.add(`${content.className}-link`);
    link.href = url;
    link.appendChild(content);
    return link;
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

function createParagraph(className, text) {
    const span = document.createElement("span");
    span.classList.add(className);
    span.textContent = text;
    return span;
}

function createProductArticle(item, products) {
    const article = document.createElement("article");
    article.classList.add("product-item");
    article.id = item.id;

    const imgLink = createLink(`/product/${item.id}`, createImage(item.image, "product"));
    const nameLink = createLink(`/product/${item.id}`, createHeading("product-item__name", item.name));
    const price = createParagraph("product-item__price", item.price);
    const trash = createImage("../images/trash.png", "trash");
    addEventListenerTrash(trash, products);

    article.append(imgLink, nameLink, price, trash);

    return article;
}

function createCartContent(products) {
    const productList = document.querySelector(".cart__product-list");
    products.forEach((item) => {
        const article = createProductArticle(item, products);
        productList.appendChild(article);
    });

    const productsCounter = document.querySelector(".cart__header-products span");
    createProductsCounter(productsCounter, products.length);

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
