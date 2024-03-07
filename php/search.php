<html>
<head>
    <meta charset="UTF-8" />
    <title>Saro Search</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/search.css">
    <link rel="stylesheet" type="text/css" href="../css/card.css">
    <link rel="stylesheet" type="text/css" href="../css/filter.css">
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
                        <i id="searchIcon" class="bi bi-search"></i>
                        <div id="searchInput" class="search-input" style="display: none;">
                            <input type="search" placeholder="Search..." id="searchField" style="padding-right: 25px;" name="search">
                            <i class="bi bi-x" id="closeIcon"></i>
                        </div>
                    </div>
                </form>
                <?php
                session_start();

                if(isset($_SESSION['user_id'])) {
                    echo '<a href="./prestiti.php"><i class="bi bi-folder"></i></a>
                          <a href="./user.php"><i class="bi bi-person"></i></a>';
                } else {
                    echo '<button class="button-21" role="button" onclick="window.location.href=\'./login.php\'">Accedi</button>';
                }
                ?>
            </div>
        </div>
    </nav>
    <section id="search-section">
        <div class="backgroung-search"></div>
        <div class="search-results-details">
            <div class="search-input-container">
                <div class="search-input-with-dropdown">
                    <div class="left-side-wrapper">
                        <i class="bi bi-search fill-current search-icon"></i>
                        <form id="searchFormbig" action="./search.php" method="GET" class="search-input-form">
                            <input id="searchbig" type="search" placeholder="Search..." value="<?php echo $_GET['search']; ?>" class="search-input-big">
                            <div class="circle-icon">
                                <i class="bi bi-x" id="closeIconbig"></i>
                            </div>                        
                        </form>
                    </div>
                </div>
            </div>
            <h1 class="search-results-heading"><?php echo ucfirst($_GET['search']); ?></h1>
            <p class="search-results-description">Explore <?php echo $_GET['search']; ?> and more</p>
        </div>
    </section>
    <section id="filter-section">
        <div class="filter-subnav">
            <div class="filter-type">
                <div class="filter-categories">
                    <ul>
                        <?php
                            require_once './db.php';

                            $sql = "SELECT categoria FROM categorie";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $category = $row['categoria'];
                                    $isActive = (isset($_GET['search']) && $_GET['search'] == strtolower($category)) ? 'active' : '';
                                    echo "<li class='category $isActive'>
                                        <a title='$category' href='http://localhost/saro/saro-tecnoteca/php/search.php?search=" . strtolower($category) . "'>".ucfirst($category)."</a>
                                    </li>";
                                }
                            } else {
                                echo "Nessuna categoria trovata";
                            }

                            $conn->close();
                        ?>
                    </ul>
                </div>
                <div class="filter-settings">
                    <a id="filter-btn" class="filter-btn" data-dropdown-state="closed">
                        <i class="bi bi-filter"></i>
                        <span class="meatball">0</span>
                        <span class="label" title="Filters">Filters</span>
                    </a>
                    <div class="dropdown" id="filterDropdown" style="display: none;">
                        <div class="filter-dropdown-content">
                            <div class="filter-dropdown-item">
                                <label for="filterType">Filter by Type:</label>
                                <select id="filterType" name="filterType">
                                    <option value="">All</option>
                                    <option value="hardware">Hardware</option>
                                    <option value="software">Software</option>
                                </select>
                            </div>
                            <div class="filter-dropdown-item">
                                <label for="filterCenter">Filter by Center:</label>
                                <select id="filterCenter" name="filterCenter">
                                    <option value="">All</option>
                                    <?php
                                        require_once './db.php';

                                        $sql = "SELECT * FROM centri";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $center = $row['nome_centro'];
                                                echo "<option value='$center'>$center</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No centers found</option>";
                                        }

                                        $conn->close();
                                    ?>
                                </select>
                            </div>
                            <div class="filter-dropdown-item">
                                <label for="filterColor">Filter by Color:</label>
                                <input type="color" id="filterColor" name="filterColor">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <section>
        <div class="main-full">
            <ol class="shots-grid">
                <?php
                    require_once './db.php';

                    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
                        $search_term = $_GET['search'];
                        $search_term = urldecode($search_term);

                        $sql = "SELECT articoli.* FROM articoli 
                            JOIN categorie ON articoli.fk_categoria = categorie.id_categoria 
                            JOIN centri ON articoli.fk_centro = centri.id_centro 
                            WHERE articoli.nome LIKE '%$search_term%' OR 
                            articoli.numero_inventario = '$search_term' OR 
                            articoli.stato LIKE '%$search_term%' OR 
                            categorie.categoria LIKE '%$search_term%' OR 
                            categorie.tipologia LIKE '%$search_term%' OR 
                            centri.nome LIKE '%$search_term%'";
                        $result = $conn->query($sql);

                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $id = $row['id_articolo'];
                                $nome = $row["nome"];
                                $colore = $row["colore"];
                                $img = $row["img"];

                                echo '<li>
                                        <div class="card"  style="--bg-card: #'.$colore.';">
                                            <div class="imgBx">
                                                <img src="../img/articoli/'.$img.'">
                                            </div>
                                            <div class="contentBx">
                                                <h2>'.ucfirst($nome).'</h2>
                                                <div class="color">
                                                    <h3>Color :</h3>
                                                    <span style="--bg-color: #'.$colore.';"></span>
                                                </div>
                                                <a href="./product.php?productid='.$id.'">More info</a>
                                            </div>
                                        </div>
                                    </li>';
                            }
                        } else {
                            echo "<li></li><li><p style='text-align: center; font-size: 22px;'><strong>Nessun risultato trovato</strong></p></li><li></li>";
                        }
                    } else {
                        echo "<li><p>Nessun termine di ricerca specificato</p></li>";
                    }
                    $conn->close();
                ?>
            </ol>
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

    const searchForm2 = document.getElementById('searchFormbig');
    const searchField2 = document.getElementById('searchbig');

    searchForm2.addEventListener('submit', function (e) {
        e.preventDefault();
        const searchValue = searchField2.value.trim();
        if (searchValue !== '') {
            window.location.href = `./search.php?search=${encodeURIComponent(searchValue)}`;
        }
    });

    const closeIconbig = document.getElementById('closeIconbig');

    closeIconbig.addEventListener('click', function () {
        searchField2.value = '';
    });
</script>
</html>