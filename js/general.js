document.addEventListener("DOMContentLoaded", function () {
    const searchIcon = document.getElementById("searchIcon");
    const searchInput = document.getElementById("searchInput");

    searchIcon.addEventListener("click", function (e) {
        e.preventDefault();
        toggleSearchInput();
    });

    function toggleSearchInput() {
        if (searchInput.style.display === "none") {
            searchInput.style.display = "block";
            document.getElementById("searchField").focus();
        } else {
            searchInput.style.display = "none";
        }
    }
});

document.addEventListener('click', function (event) {
    const searchContainer = document.querySelector('.search-container');
    const searchInput = document.getElementById('searchInput');

    if (!searchContainer.contains(event.target) && searchInput.style.display === 'block') {
        searchInput.style.display = 'none';
    }
});

const searchIcon = document.getElementById('searchIcon');
const searchInput = document.getElementById('searchInput');
const searchField = document.getElementById('searchField');
const searchForm = document.getElementById('searchForm');

const closeIcon = document.getElementById('closeIcon');

closeIcon.addEventListener('click', function () {
    searchField.value = '';
});