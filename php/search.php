<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Saro Search</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/search.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-links-left">
                <a href="./articoli.php">Articoli</a>
            </div>
            <div class="navbar-logo">
                <a href="../index.php"><img src="../img/logo/logo-black.svg" /></a>
            </div>
            <div class="navbar-icons">
                <form id="searchForm" action="./search.php" method="GET">
                    <div class="search-container">
                        <a href="#" id="searchIcon"><i class="bi bi-search"></i></a>
                        <div id="searchInput" class="search-input" style="display: none;">
                            <input type="search" placeholder="Search..." id="searchField" style="padding-right: 25px;" name="search">
                            <i class="bi bi-x" id="closeIcon"></i>
                        </div>
                    </div>
                </form>
                <a href="./prestiti.php"><i class="bi bi-folder"></i></a>
                <a href="./user.php"><i class="bi bi-person"></i></a>
            </div>
        </div>
    </nav>
    <section class="search-section">
        <div class="backgroung-search"></div>
        <div class="search-results-details">
            <div class="search-input-container">
                <div class="search-input-with-dropdown">
                    <div class="left-side-wrapper">
                        <i class="bi bi-search fill-current search-icon"></i>
                        <form action="" class="search-input-form">
                            <input id="search" type="search" placeholder="Search..." value="<?php echo $_GET['search']; ?>" class="search-input-big">
                            <div class="circle-icon">
                                <i class="bi bi-x"></i>
                            </div>                        
                        </form>
                    </div>
                </div>
            </div>
            <h1 class="search-results-heading"><?php echo ucfirst($_GET['search']); ?></h1>
            <p class="search-results-description">Explore <?php echo $_GET['search']; ?> and more</p>
        </div>
    </section>
    
</body>
<script src="../js/general.js">
    searchForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const searchValue = searchField.value.trim();
    if (searchValue !== '') {
        window.location.href = `./search.php?search=${encodeURIComponent(searchValue)}`;
    }
});
</script>
</html>