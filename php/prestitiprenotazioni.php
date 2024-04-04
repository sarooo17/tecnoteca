<?php
    session_start();
    if (isset($_SESSION['user_type'])) {
        $user_type = $_SESSION['user_type'];

        if ($user_type != 'cliente') {
            header('Location: access_denied.php');
            exit();
        }
    } else {
        header('Location: ../html/login.html');
        exit();
    }
?>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Prestiti e Prenotazioni</title>
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
                        <h1>Le tue prenotazioni</h1>
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

                                $sql = "SELECT * FROM prenotazioni WHERE fk_utente = ? ORDER BY FIELD(stato, 'da ritirare', 'ritirato'), data_ritiro";                                
                                $stmt = $conn->prepare($sql);
                                $bindResult = $stmt->bind_param("i", $idutente);
                                $executeResult = $stmt->execute();
                                $result = $stmt->get_result();

                                $printedEffettuatiHeaderpren = false;

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $idprenotazione = $row['id_prenotazione'];
                                        $fk_articolo = $row['fk_articolo'];
                                        $dataritiro = $row['data_ritiro'];
                                        $datarestituzione = $row['data_restituzione'];
                                        $dataritiro_format = DateTime::createFromFormat('Y-m-d', $row['data_ritiro']);
                                        $dataritiro_format = $dataritiro_format -> format('d-m-Y');
                                        $datarestituzione_format = DateTime::createFromFormat('Y-m-d', $row['data_restituzione']);
                                        $datarestituzione_format = $datarestituzione_format -> format('d-m-Y');
                                        $stato = $row['stato'];
                                        $sql = "SELECT * FROM articoli WHERE id_articolo = ?";
                                        $stmt = $conn->prepare($sql);
                                        $bindResult = $stmt->bind_param("i", $fk_articolo);
                                        $executeResult = $stmt->execute();
                                        $resultArticolo = $stmt->get_result();
                                        $rowArticolo = $resultArticolo->fetch_assoc();

                                        if ($stato == 'ritirato' && !$printedEffettuatiHeaderpren) {
                                            echo '<div class="braker">
                                                    <i class="bi bi-chevron-down"></i>
                                                    <p><strong>Ritirati</strong></p>
                                                    <i class="bi bi-chevron-down"></i>
                                                </div>';
                                            $printedEffettuatiHeaderpren = true;
                                        }

                                        echo '<div class="box-data">
                                                <div class="articolo">
                                                    <p><strong>'.$idprenotazione.'</strong></p>
                                                    <p>'.$rowArticolo['numero_inventario'].'</p>
                                                    <p>'.ucfirst($rowArticolo['nome']).'</p>
                                                    <p>'.$dataritiro_format.'</p>
                                                    <p>'.$datarestituzione_format.'</p>';
                                                    if ($stato == 'da ritirare') {
                                                        echo '<p class="trash">'.$stato.'</p>';
                                                    }else{
                                                        echo '<p class="disponibile">'.$stato.'</p>';
                                                    }
                                        echo '  </div>';
                                                $data_odierna = date('Y-m-d');
                                                if ($dataritiro > $data_odierna && $stato == 'da ritirare') {
                                                    echo '<div class="btns">
                                                            <div id="popup-overlay" style="display: none;"></div>
                                                            <a href="#" class="open-popup-delete" data-id="'.$idprenotazione.'">
                                                                <i class="bi bi-trash trash"></i>
                                                            </a>
                                                            <div id="popup-del" class="popup" style="display: none;">
                                                                <div class="popup-content">
                                                                </div>
                                                            </div>
                                                          </div>';
                                                }
                                        echo '</div>
                                            <div class="line"></div>';
                                    }
                                } else {
                                    echo "<div class='no-data'><strong><p>Nessuna prenotazione effettuata</p></strong></div>";
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
                        <h1>I tuoi prestiti</h1>
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

                                $sql = "SELECT * FROM prestiti WHERE fk_utente = ? ORDER BY FIELD(stato, 'non restituito', 'restituito'), data_inizio_prestito";
                                $stmt = $conn->prepare($sql);
                                $bindResult = $stmt->bind_param("i", $idutente);
                                $executeResult = $stmt->execute();
                                $result = $stmt->get_result();

                                $printedEffettuatiHeaderpres = false;

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $idprestito = $row['id_prestito'];
                                        $fk_articolo = $row['fk_articolo'];
                                        $dataritiro = $row['data_inizio_prestito'];
                                        $dataritiro_format = DateTime::createFromFormat('Y-m-d', $row['data_inizio_prestito']);
                                        $dataritiro_format = $dataritiro_format -> format('d-m-Y');
                                        $datascadenza = $row['data_scadenza_prestito'];
                                        $datascadenza_format = DateTime::createFromFormat('Y-m-d', $row['data_scadenza_prestito']);
                                        $datascadenza_format = $datascadenza_format -> format('d-m-Y');
                                        $datarestituzione = $row['data_restituzione'];
                                        $datarestituzione_format = DateTime::createFromFormat('Y-m-d', $row['data_restituzione']);
                                        $datarestituzione_format = $datarestituzione_format -> format('d-m-Y');
                                        $statoprestito = $row['stato'];
                                        $sql = "SELECT * FROM articoli WHERE id_articolo = ?";
                                        $stmt = $conn->prepare($sql);
                                        $bindResult = $stmt->bind_param("i", $fk_articolo);
                                        $executeResult = $stmt->execute();
                                        $resultArticolo = $stmt->get_result();
                                        $rowArticolo = $resultArticolo->fetch_assoc();

                                        if ($statoprestito == 'restituito' && !$printedEffettuatiHeaderpres) {
                                            echo '<div class="braker">
                                                    <i class="bi bi-chevron-down"></i>
                                                    <p><strong>Restituiti</strong></p>
                                                    <i class="bi bi-chevron-down"></i>
                                                </div>';
                                            $printedEffettuatiHeaderpres = true;
                                        }

                                        echo '<div class="box-data">
                                                <div class="articolo">
                                                    <p><strong>'.$idprestito.'</strong></p>
                                                    <p>'.$rowArticolo['numero_inventario'].'</p>
                                                    <p>'.ucfirst($rowArticolo['nome']).'</p>
                                                    <p>'.$dataritiro_format.'</p>
                                                    <p>'.$datascadenza_format.'</p>';
                                                    if (!empty($datarestituzione)) {
                                                        echo '<p>'.$datarestituzione_format.'</p>';
                                                    }else{
                                                        echo '<p class="trash">Non restituito</p>';
                                                    }
                                        echo '  </div>
                                            </div>';
                                    }
                                } else {
                                    echo "<div class='no-data'><strong><p>Nessun prestito effettuato</p></strong></div>";
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
<script>
    var linksdelete = document.querySelectorAll('.open-popup-delete');

    function addClickListener(links, isDel, popupId) {
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function(event) {
                event.preventDefault();

                var id = this.getAttribute('data-id');

                if(isDel){
                    var formHtml = '<span class="close" onclick="closePopup(event, \'popup-del\')">&times;</span>';
                    formHtml += '<form action="prenotazioni-delete.php" method="post">';
                    formHtml += '<h3>Sei sicuro di voler eliminare la prenotazione con codice ' + id + '?</h3>';
                    formHtml += '<input type="hidden" name="id" value="' + id + '">';
                    formHtml += '<input type="submit" value="Elimina">';
                    formHtml += '</form>';

                    document.getElementById('popup-del').querySelector('.popup-content').innerHTML = formHtml;
                }
                
                var popupElement = document.getElementById(popupId);
                if (popupElement) {
                    popupElement.style.display = 'block';
                } else {
                    console.error('Elemento con id ' + popupId + ' non trovato');
                }
                document.getElementById('popup-overlay').style.display = 'block';
            });
        }
    }

    addClickListener(linksdelete, true, 'popup-del'); 

    function closePopup(event, popupId) {
        var popupElement = document.getElementById(popupId);
        if (popupElement) {
            popupElement.style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
        } else {
            console.error('Elemento con id ' + popupId + ' non trovato');
        }
    }

</script>
</html>