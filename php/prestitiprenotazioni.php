<html>
<head>
    <meta charset="UTF-8" />
    <title>Account</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/user.css">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
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
    <section>
        <div class="col-pres">
            <div class="row">
                <div class="account-box">
                    <div class="box-title art">
                        <i class="bi bi-calendar-week icon-title"></i>
                        <h1>Prenotazioni</h1>
                    </div>
                    <div class="line"></div>
                    <div class="box-data top-tab">
                        <p><u><strong>Cod</strong></u></p>
                        <p><u><strong>N art</strong></u></p>
                        <p><u><strong>Articolo</strong></u></p>
                        <p><u><strong>Ritiro</strong></u></p>
                        <p><u><strong>Restituzione</strong></u></p>
                    </div>
                    <div class="line"></div>
                    <div class="scrollable-section">
                        <?php
                            require_once './db.php';
                            if (isset($_SESSION['user_id'])) {
                                $idutente = $_SESSION['user_id'];

                                $sql = "SELECT * FROM prenotazioni WHERE fk_utente = ?";
                                $stmt = $conn->prepare($sql);
                                $bindResult = $stmt->bind_param("i", $idutente);
                                $executeResult = $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $idprenotazione = $row['id_prenotazione'];
                                        $fk_articolo = $row['fk_articolo'];
                                        $dataritiro = $row['data_ritiro'];
                                        $datarestituzione = $row['data_restituzione'];
                                        $sql = "SELECT * FROM articoli WHERE id_articolo = ?";
                                        $stmt = $conn->prepare($sql);
                                        $bindResult = $stmt->bind_param("i", $fk_articolo);
                                        $executeResult = $stmt->execute();
                                        $resultArticolo = $stmt->get_result();
                                        $rowArticolo = $resultArticolo->fetch_assoc();

                                        echo '<div class="box-data">
                                                <div class="articolo">
                                                    <p><strong>'.$idprenotazione.'</strong></p>
                                                    <p>'.$rowArticolo['numero_inventario'].'</p>
                                                    <p>'.ucfirst($rowArticolo['nome']).'</p>
                                                    <p>'.$dataritiro.'</p>
                                                    <p>'.$datarestituzione.'</p>
                                                </div>
                                            </div>';
                                    }
                                } else {
                                    echo "<div class='no-data'><strong><p>Nessun articolo trovato</p></strong></div>";
                                }
                            } else {
                                header('Location: login.php');
                            }
                        ?>
                    </div>
                </div>
                <div class="account-box prest-pren-margin">
                    <div class="box-title art">
                        <i class="bi bi-ui-checks icon-title"></i>
                        <h1>Prestiti</h1>
                    </div>
                    <div class="line"></div>
                    <div class="box-data top-tab">
                        <p><u><strong>Cod</strong></u></p>
                        <p><u><strong>N art</strong></u></p>
                        <p><u><strong>Articolo</strong></u></p>
                        <p><u><strong>Ritiro</strong></u></p>
                        <p><u><strong>Restituzione</strong></u></p>
                    </div>
                    <div class="line"></div>
                    <div class="scrollable-section">
                        <?php
                            require_once './db.php';
                            if (isset($_SESSION['user_id'])) {
                                $idutente = $_SESSION['user_id'];

                                $sql = "SELECT * FROM prestiti WHERE fk_utente = ?";
                                $stmt = $conn->prepare($sql);
                                $bindResult = $stmt->bind_param("i", $idutente);
                                $executeResult = $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $idprenotazione = $row['id_prestito'];
                                        $fk_articolo = $row['fk_articolo'];
                                        $dataritiro = $row['data_inizio_prestito'];
                                        $datascadenza = $row['data_scadenza_prestito'];
                                        $datarestituzione = $row['data_restituzione'];
                                        $sql = "SELECT * FROM articoli WHERE id_articolo = ?";
                                        $stmt = $conn->prepare($sql);
                                        $bindResult = $stmt->bind_param("i", $fk_articolo);
                                        $executeResult = $stmt->execute();
                                        $resultArticolo = $stmt->get_result();
                                        $rowArticolo = $resultArticolo->fetch_assoc();

                                        echo '<div class="box-data">
                                                <div class="articolo">
                                                    <p><strong>'.$idprestito.'</strong></p>
                                                    <p>'.$rowArticolo['numero_inventario'].'</p>
                                                    <p>'.ucfirst($rowArticolo['nome']).'</p>
                                                    <p>'.$dataritiro.'</p>
                                                    <p>'.$datascadenza.'</p>';
                                                    if (!empty($datarestituzione)) {
                                                        echo '<p>'.$datarestituzione.'</p>';
                                                    }
                                        echo '  </div>
                                            </div>';
                                    }
                                } else {
                                    echo "<div class='no-data'><strong><p>Nessun articolo trovato</p></strong></div>";
                                }
                            } else {
                                header('Location: login.php');
                            }
                        ?>
                    </div>
                </div>
            </div>
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