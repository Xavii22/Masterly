const send = document.querySelector(".button");

send.addEventListener("click", function () {
    sendLocalStorage();
});

async function sendLocalStorage() {
    try {
        const data = {
            "name": document.querySelector("#name").value,
            "email": document.querySelector("#email").value,
            "password": document.querySelector("#password").value,
            "passwordConfirmation": document.querySelector("#password_confirmation").value,
            "localStorage": JSON.parse(localStorage.getItem("cart"))
        }

        const response = await fetch("/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            localStorage.removeItem('cart');
        }

    } catch (error) {
        console.error(error);
    }
}
