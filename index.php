<!DOCTYPE html>
<html>
<head>
    <title>Saro tecnoteca</title>
    <link id="favicon" rel="icon" href="./img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="./css/general.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-links-left">
                <a href="./php/articoli.php">Articoli</a>
            </div>
            <div class="navbar-logo">
                <a href="index.php"><img src="./img/logo/logo-black.svg" /></a>
            </div>
            <div class="navbar-icons">
                <form id="searchForm" action="./php/search.php" method="GET">
                    <div class="search-container">
                        <a href="#" id="searchIcon"><i class="bi bi-search"></i></a>
                        <div id="searchInput" class="search-input" style="display: none;">
                            <input type="search" placeholder="Search..." id="searchField" style="padding-right: 25px; padding-left: 10px;" name="search">
                            <i class="bi bi-x" id="closeIcon"></i>
                        </div>
                    </div>
                </form>
                <a href="./php/prestiti.php"><i class="bi bi-folder"></i></a>
                <a href="./php/user.php"><i class="bi bi-person"></i></a>
            </div>
        </div>
    </nav>
    <div id="hero" class="hero-container">
        <div class="hero-text">
            <h1>Saro Tecnoteca</h1>
            <p>La tua libreria di fiducia</p>
        </div>
    </div>
    <footer class="footer-distributed">
        <div class="footer-right">
            <a href="https://www.instagram.com/saro.riccardo/?igshid=MTk0NTkyODZkYg%3D%3D&utm_source=qr"
                target=”_blank”><i class="bi-instagram"></i></a>
        </div>
        <div class="footer-left">
            <p class="footer-links">
                <a class="link-1" href="index.php">Home</a>
                <a href="./php/articoli.php">Articoli</a>
            </p>
            <p>Saro &copy; 2023</p>
        </div>
    </footer>
</body>
<script src="./js/general.js">
    searchForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const searchValue = searchField.value.trim();
    if (searchValue !== '') {
        window.location.href = `./php/search.php?search=${encodeURIComponent(searchValue)}`;
    }
});
</script>
</html>