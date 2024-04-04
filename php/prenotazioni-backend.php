<?php
    session_start();
    if (isset($_SESSION['user_type'])) {
        $user_type = $_SESSION['user_type'];

        if ($user_type == 'cliente') {
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
        <title>Saro Prenotazioni</title>
        <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />
        <link rel="stylesheet" type="text/css" href="../css/backend.css">
        <link rel="stylesheet" type="text/css" href="../css/general.css">
        <link rel="stylesheet" type="text/css" href="../css/articoli-backend.css">
    </head>
    <body>
        <nav>
            <ul>
                <li class="logo">
                    <a href="./backend.php">
                        <img src="../img/logo/favicon.svg">
                    </a>
                </li>
                <li>
                    <a href="./backend.php">
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="./articoli-backend.php">
                        <i class="bi bi-box-seam"></i>
                        <span>Articoli</span>
                    </a>
                </li>	
                <li>
                    <a href="./prenotazioni-backend.php">
                        <i class="bi bi-calendar-week"></i>
                        <span>Prenotazioni</span>
                    </a>
                </li>
                <li>
                    <a href="./prestiti-backend.php">
                        <i class="bi bi-ui-checks"></i>
                        <span>Prestiti</span>
                    </a>
                </li>
                <?php
                    if ($_SESSION['user_type'] === 'admin') {
                        echo '<li>
                                <a href="./utenti-backend.php">
                                    <i class="bi bi-people"></i>
                                    <span>Utenti</span>
                                </a>
                            </li>';
                    }
                ?>	
                <li>
                    <a href="./user.php">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <p>ciao</p>
        <section>
            <div class="col-art-back">
                <div class="row-art-back">
                    <div class="box">
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

                                $sql = "SELECT prenotazioni.* FROM prenotazioni
                                        JOIN articoli ON prenotazioni.fk_articolo = articoli.id_articolo";

                                if ($_SESSION['user_type'] == 'operatore') {
                                    $operator_centroid = $_SESSION['operator_centroid'];
                                    $sql .= " WHERE articoli.fk_centro = " . $operator_centroid;
                                }

                                $sql .= " ORDER BY FIELD(prenotazioni.stato, 'da ritirare', 'ritirato'), prenotazioni.data_ritiro";

                                $stmt = $conn->prepare($sql);
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
                                                            <form action="prenotazioni-ritiro.php" style="margin: 0;" method="post">
                                                                <input type="hidden" name="id" value="'.$idprenotazione.'">
                                                                <button class="button-21" type="submit">Ritiro</button>
                                                            </form>
                                                            <div id="popup" class="popup" style="display: none;">
                                                                <div class="popup-content">
                                                                </div>
                                                            </div>
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
                </div>
            </div>
        </section>
    </body>
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