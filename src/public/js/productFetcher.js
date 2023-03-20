function createProductsPrice(price, products) {
    price.textContent = products.map(product => product.price).reduce((acc, amount) => acc + amount);
}

function createProductsCounter(counter, totalProducts) {
    counter.textContent = totalProducts;
}

function createProductArticle(item) {
    const article = document.createElement("article");
    article.classList.add("product-item");

    const imgLink = createLink(
        `/product/${item.id}`,
        createImage(item.image, item.name)
    );
    const nameLink = createLink(
        `/product/${item.id}`,
        createHeading(1, "product-item__name", item.name)
    );
    const price = createParagraph("product-item__price", item.price);

    article.append(imgLink, nameLink, price);

    return article;
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
    img.classList.add("product-item__image");
    img.src = src;
    img.alt = alt;
    return img;
}

function createHeading(level, className, text) {
    const heading = document.createElement(`h${level}`);
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

function modifyCartContent(products) {
    const productList = document.querySelector(".cart__product-list");
    products.forEach((item) => {
        const article = createProductArticle(item);
        productList.appendChild(article);
    });

    const productsCounter = document.querySelector(
        ".cart__header-products span"
    );
    createProductsCounter(productsCounter, products.length);

    const productsPrice = document.querySelector(".cart__summary-price span");
    createProductsPrice(productsPrice, products);
}

async function fetchProducts() {
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

        modifyCartContent(products);
    } catch (error) {
        console.error(error);
    }
}

fetchProducts();
