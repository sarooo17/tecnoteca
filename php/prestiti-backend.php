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

                                    $sql = "SELECT prestiti.* FROM prestiti
                                            JOIN articoli ON prestiti.fk_articolo = articoli.id_articolo";

                                    if ($_SESSION['user_type'] == 'operatore') {
                                        $operator_centroid = $_SESSION['operator_centroid'];
                                        $sql .= " WHERE articoli.fk_centro = " . $operator_centroid;
                                    }

                                    $sql .= " ORDER BY FIELD(prestiti.stato, 'non restituito', 'restituito'), prestiti.data_inizio_prestito";

                                    $stmt = $conn->prepare($sql);
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
                                            $sqlutente = "SELECT * FROM utenti WHERE id_utente = ?";
                                            $stmtutente = $conn->prepare($sqlutente);
                                            $bindResult = $stmtutente->bind_param("i", $idutente);
                                            $executeResult = $stmtutente->execute();
                                            $resultutente = $stmtutente->get_result();
                                            $rowutente = $resultutente->fetch_assoc();

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
                                                        <p>'.$rowutente['id_utente'].'</p>
                                                        <p>'.$dataritiro_format.'</p>
                                                        <p>'.$datascadenza_format.'</p>';
                                                        if ($datarestituzione != '0000-00-00') {
                                                            echo '<p>'.$datarestituzione_format.'</p>';
                                                        }else{
                                                            echo '<p class="trash">'.ucfirst($statoprestito).'</p>';
                                                        }
                                            echo '  </div>';
                                                if ($statoprestito == 'non restituito') {
                                                    echo '<div class="btns">
                                                            <form action="prestiti-riconsegna.php" style="margin: 0;" method="post">
                                                                <input type="hidden" name="id" value="'.$idprestito.'">
                                                                <button class="button-21" type="submit">Restituzione</button>
                                                            </form>
                                                          </div>';
                                                }
                                                        
                                                echo '</div>
                                                    <div class="line"></div>';
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