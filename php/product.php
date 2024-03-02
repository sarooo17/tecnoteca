<html>
<head>
    <meta charset="UTF-8" />
    <title>Saro Search</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/product.css">

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
    <section id="product">
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
                $productColor = $row['colore'];
                $productPlace = $row['fk_centro'];
                $productType = $row['fk_categoria'];

                $sql = "SELECT nome FROM centri WHERE id_centro = $productPlace";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $centerName = $row['nome'];
                    }
                }

                $sql = "SELECT categoria FROM categorie WHERE id_categoria = $productType";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $categoryName = $row['categoria'];
                    }
                }
            }

            echo "<div class='row'>
                    <div class='col-desc'>
                        <div class='top'>
                            <p class='novità'>Novità</p>
                            <h1>$productName</h1>
                            <p class='categoria'>".ucfirst($categoryName)."</p>
                            <div class='color'>
                                <h3>Color :</h3>
                                <span style='--bg-color: #$productColor;'></span>
                            </div>
                            <p>".ucfirst($productDescription)."</p>
                        </div>
                        <div class='bottom'>
                            <div class='row-where'>
                                <div class='icon-position'><i class='bi bi-bag-heart pin-point'></i></div>
                                <div class='col-where'>
                                    <div><p>Prenota ora. Ritiro, in negozio:</p></div>
                                    <div><p>Oggi presso <a href='./php/map.php'>".ucfirst($centerName)."</a></p></div>
                                </div>
                            </div>
                            <div class='prenota'>
                                <button type='button' class='button-21' role='button' data-bs-toggle='popover' data-bs-placement='top' title='Seleziona una data'>
                                    Prenota
                                </button>
                                <div id='popover-content' style='display: none;'>
                                    <input type='date' id='dateSelector'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-img'>
                        <img src='../img/articoli/$productImg' />
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