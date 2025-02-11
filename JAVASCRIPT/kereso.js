const search = () => {
    const searchBox = document.getElementById("search-item").value.toUpperCase();
    const fogalomSections = document.querySelectorAll(".fogalom");

    fogalomSections.forEach(section => {
        const fogalomTitle = section.querySelector('h3').textContent.toUpperCase();
        const sectionContent = section.querySelector('p').textContent.toUpperCase();

        if (fogalomTitle.includes(searchBox) || sectionContent.includes(searchBox)) {
            section.style.display = "block";
        } else {
            section.style.display = "none";
        }
    });
}
