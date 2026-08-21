function confirmDelete() {
    return confirm("Are you sure you want to delete this blog?");
}

document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.querySelector(".search-form input");

    if (searchInput) {
        searchInput.addEventListener("focus", function () {
            this.style.borderColor = "#6d28d9";
        });

        searchInput.addEventListener("blur", function () {
            this.style.borderColor = "#d1d5db";
        });
    }

});