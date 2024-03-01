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
                <a href="./prestiti.php"><i class="bi bi-folder"></i></a>
                <a href="./user.php"><i class="bi bi-person"></i></a>
            </div>
        </div>
    </nav>
    <section>
        <!-- fare come pagina prodotto apple una riga due colonne sx text dx img -->
        <?php
        $productId = $_GET['productid'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "saro_tecnoteca";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM articoli WHERE id_articolo= $productId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productName = $row['nome'];
                $productDescription = $row['descrizione'];
                $productImg = $row['img'];
            }

            echo "<div class='row'>
                    <div class='col-desc'>
                        <h1>$productName</h1>
                        <p>$productDescription</p>
                    </div>
                    <div class='col-img'>
                        <img src='../img/products/$productImg' />
                    </div>
                </div>";
        } else {
            echo "Product not found";
        }
        ?>
        
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