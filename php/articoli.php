<html>
<head>
    <meta charset="UTF-8" />
    <title>Saro Articoli</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/card.css">
    <link rel="stylesheet" type="text/css" href="../css/filter.css">
    <link rel="stylesheet" type="text/css" href="../css/articoli.css">
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
                    echo '<a href="./prestitiprenotazioni.php"><i class="bi bi-folder"></i></a>
                          <a href="./user.php"><i class="bi bi-person"></i></a>';
                } else {
                    echo '<button class="button-21" role="button" onclick="window.location.href=\'../html/login.html\'">Accedi</button>';
                }
                ?>
            </div>
        </div>
    </nav>
    <section id="filter-section" class="f-section">
        <div class="backgroung-search">
            <h1>Articoli</h1>
        </div>
        <div class="filter-subnav">
            <div class="filter-type">
                <div class="search-results-details">
                    <div class="search-input-container">
                        <div class="search-input-with-dropdown">
                            <div class="left-side-wrapper">
                                <i class="bi bi-search fill-current search-icon"></i>
                                <form id="searchFormbig" action="./search.php" method="GET" class="search-input-form">
                                    <input id="searchbig" type="search" placeholder="Search..." class="search-input-big">
                                    <div class="circle-icon">
                                        <i class="bi bi-x" id="closeIconbig"></i>
                                    </div>                        
                                </form>
                            </div>
                        </div>
                    </div>
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
    <section id="articoli">
        <div class="main-full">
            <ol class="shots-grid">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "saro_tecnoteca";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if($conn->connect_error) {
                        die("Connessione al database fallita: ".$conn->connect_error);
                    }

                    $sql = "SELECT * FROM articoli";
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
                                            <a href="./product.php?productid='.$id.'">More info</a>
                                        </div>
                                    </div>
                                </li>';
                        }
                    } else {
                        echo "<li></li><li><p style='text-align: center; font-size: 22px;'><strong>Nessun risultato trovato</strong></p></li><li></li>";
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