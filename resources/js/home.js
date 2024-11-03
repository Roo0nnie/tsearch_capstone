function abstract(elementId, maxLength) {
    const element = document.getElementById(elementId);
    if (element) {
        const text = element.textContent;
        if (text.length > maxLength) {
            element.textContent = text.substring(0, maxLength) + "...";
        }
    }
}

abstract("abstract", 500);
