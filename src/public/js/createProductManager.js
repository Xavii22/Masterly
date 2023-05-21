function validateImage(event, index) {
    let input = event.target;
    let file = input.files[0];

    if (!file) {
        return;
    }

    let fileSize = file.size;
    let maxSize = 1024 * 1024;
    let allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    let fileExtension = file.name.split(".").pop().toLowerCase();

    if (!allowedExtensions.includes(fileExtension)) {
        showError(index, "El archivo seleccionado no es una imagen válida.");
        resetInput(input);
        return;
    }

    if (fileSize > maxSize) {
        showError(
            index,
            "El archivo excede el tamaño máximo permitido de 1 MB."
        );
        resetInput(input);
        return;
    }

    let img = new Image();
    img.onload = () => {
        let width = img.width;
        let height = img.height;
        let maxWidth = 800;
        let maxHeight = 600;

        if (width > maxWidth || height > maxHeight) {
            showError(
                index,
                "La imagen excede las dimensiones máximas permitidas de 800x600."
            );
            resetInput(input);
            return;
        }

        clearError(index);
    };

    img.src = URL.createObjectURL(file);
}

let showError = (index, message) => {
    document.getElementById("error_" + index).textContent = message;
};

let clearError = (index) => {
    document.getElementById("error_" + index).textContent = "";
};

let resetInput = (input) => {
    input.value = "";
};
