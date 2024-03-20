<html>
    <head>
        <title>Saro Utenti</title>
        <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

        <link rel="stylesheet" type="text/css" href="../css/backend.css">
        <link rel="stylesheet" type="text/css" href="../css/general.css">
        <link rel="stylesheet" type="text/css" href="../css/articoli-backend.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    session_start();
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
                    <a href="#">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <section>
            <div class="col-art-back">
                <div class="row-art-back">
                    <div class="box">
                        <div class="box-title art">
                                <i class="bi bi-box-seam icon-title"></i>
                                <h1>Utenti</h1>
                        </div>
                        <div class="line"></div>
                        <div class="box-data top-tab">
                            <p><u><strong>Nome</strong></u></p>
                            <p><u><strong>Cognome</strong></u></p>
                            <p><u><strong>Email</strong></u></p>
                            <p><u><strong>Tipologia</strong></u></p>
                            <div class="btns">
                                <a href="#" class="open-popup-new">
                                    <i class="bi bi-person-add"></i>
                                </a>
                                <a href="?filter=admin">
                                    <i class="bi bi-person-lock"></i>
                                </a>
                                <a href="?filter=operatori">
                                    <i class="bi bi-person-gear"></i>
                                </a>
                                <a href="?filter=clienti">
                                    <i class="bi bi-person-check"></i>
                                </a>
                                <a href="?filter=all">
                                    <i class="bi bi-people"></i>
                                </a>
                                <div id="popup-new" class="popup" style="display: none;">
                                    <div class="popup-content">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="scrollable-section">
                            <?php
                            require_once('./db.php');

                            if (isset($_GET['filter'])) {
                                $filter = $_GET['filter'];
                                if ($filter === 'admin') {
                                    $sql = "SELECT * FROM utenti WHERE tipologia_utente = 'admin'";
                                } else if ($filter === 'operatori') {
                                    $sql = "SELECT * FROM utenti WHERE tipologia_utente = 'operatore'";
                                } else if ($filter === 'clienti') {
                                    $sql = "SELECT * FROM utenti WHERE tipologia_utente = 'cliente'";
                                } else if ($filter === 'all') {
                                    $sql = "SELECT * FROM utenti";
                                }
                            } else {
                                $sql = "SELECT * FROM utenti";
                            }

                            $result = $conn->query($sql);

                            if ($result === false) {
                                die("Errore nell'esecuzione della query: " . $conn->error);
                            }

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $id = $row["id_utente"];
                                    $nome = $row["nome"];
                                    $cognome = $row["cognome"];
                                    $email = $row["email"];
                                    $tipologia_utente = $row["tipologia_utente"];
                                    $idcittà = $row["fk_città"];
                                    $img = $row["img"];

                                    $sql_category = "SELECT * FROM città WHERE id_città = $idcittà";
                                    $result_category = $conn->query($sql_category);

                                    if ($result_category->num_rows > 0) {
                                        while($row_category = $result_category->fetch_assoc()) {
                                            $città = $row_category["nome"];
                                            $provincia = $row_category["provincia"];
                                        }
                                    } else {
                                        $città = "No category found";
                                    }
                                    
                                    echo '<div class="box-data">
                                            <div class="articolo">
                                                <p><strong>'.ucfirst($nome).'</strong></p>
                                                <p>'.ucfirst($cognome).'</p>
                                                <p>'.$email.'</p>';
                                                if($tipologia_utente == "cliente"){
                                                    echo '<p class="disponibile">'.ucfirst($tipologia_utente).'</p>';
                                                }else if($tipologia_utente == "admin"){
                                                    echo '<p class="in-prestito">'.ucfirst($tipologia_utente).'</p>';
                                                }else if($stato == "operatore"){
                                                    echo '<p class="guasto">'.ucfirst($tipologia_utente).'</p>';
                                                }
                                    echo '  </div>
                                        <div class="btns">
                                            <div id="popup-overlay" style="display: none;"></div>
                                                <a href="#" class="open-popup-info" data-id="'.$id.'">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <div id="popup-info" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                        <h3 id="titolo-popup"></h3>
                                                        <span class="close" onclick="closePopup(event, \'popup-info\')">&times;</span>                                                        
                                                        <p id="nome-popup"></p>
                                                        <p id="cognome-popup"></p>
                                                    </div>
                                                </div>
                                                <a href="#" class="open-popup-mod" data-id="'.$id.'">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <div id="popup-mod" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                    </div>
                                                </div>
                                                <a href="#" class="open-popup-delete" data-id="'.$id.'">
                                                    <i class="bi bi-trash trash"></i>
                                                </a>
                                                <div id="popup-del" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    
                                    echo'<div class="line"></div>';
                                }
                            } else {
                                echo "<div class='no-data'><strong><p>Nessun utente trovato</p></strong></div>";
                            }
                            $conn->close();
                            
                                
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <script>

        var linksinfo = document.querySelectorAll('.open-popup-info');
        var linksmod = document.querySelectorAll('.open-popup-mod');
        var linksdelete = document.querySelectorAll('.open-popup-delete');
        var linksnew = document.querySelectorAll('.open-popup-new');

        function addClickListener(links, url, isMod, isDel, isNew, isRest, isDelDef, popupId) {
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function(event) {
                event.preventDefault();

                var id = this.getAttribute('data-id');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        var titoloElement = document.getElementById('titolo-popup-info');
                        var titoloElementmod = document.getElementById('titolo-popup-mod');
                        var nomeElement = document.getElementById('nome-popup');
                        var ninvElement = document.getElementById('cognome-popup');

                        if (isMod) {
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-mod\')">&times;</span>';
                            formHtml += '<form action="modifica-utente.php" method="post">';
                            formHtml += '<h3>Modifica Utente ' + data.nome + '</h3>';
                            formHtml += '<input type="hidden" name="id" value="' + data.id + '">';
                            formHtml += '<input type="text" name="nome" value="' + data.nome + '">';
                            formHtml += '<input type="text" name="cognome" value="' + data.cognome + '">';
                            formHtml += '<input type="email" name="email" value="' + data.email + '">';
                            formHtml += '<input type="text" name="tipologia" value="' + data.tipologia + '">';
                            
                            formHtml += '<input type="text" name="stato" value="' + data.stato + '">';
                            formHtml += '<input type="text" name="descrizione" value="' + data.descrizione + '">';
                            formHtml += '<input type="text" name="colore" value="' + data.colore + '">';
                            formHtml += '<input type="text" name="tipologia" value="' + data.tipologia + '">';
                            formHtml += '<input type="text" name="indirizzo" value="' + data.indirizzo + '">';
                            formHtml += '<input type="submit" value="Modifica">';
                            formHtml += '</form>';

                            document.getElementById('popup-mod').querySelector('.popup-content').innerHTML = formHtml;                        
                        } else if(isDel){
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-del\')">&times;</span>';
                            formHtml += '<form action="utenti-delete.php" method="post">';
                            formHtml += '<h3>Sei sicuro di voler eliminare l\'articolo ' + data.nome + '('+data.numero_inventario+')?</h3>';
                            formHtml += '<input type="hidden" name="id" value="' + data.id + '">';
                            formHtml += '<input type="submit" value="Elimina">';
                            formHtml += '</form>';

                            document.getElementById('popup-del').querySelector('.popup-content').innerHTML = formHtml;
                        } else if(isNew){
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-new\')">&times;</span>';
                            formHtml += '<form action="nuovo-utente.php" method="post">';
                            formHtml += '<h3>Inserisci nuovo articolo</h3>';
                            formHtml += '<input type="text" name="nome">';
                            formHtml += '<input type="text" name="numero_inventario">';
                            formHtml += '<input type="text" name="categoria">';
                            formHtml += '<input type="text" name="nome_centro">';
                            formHtml += '<input type="text" name="stato">';
                            formHtml += '<input type="text" name="descrizione">';
                            formHtml += '<input type="text" name="colore">';
                            formHtml += '<input type="submit" value="Inserisci">';
                            formHtml += '</form>';

                            document.getElementById('popup-new').querySelector('.popup-content').innerHTML = formHtml;  
                        } else {
                            if (nomeElement) {
                                nomeElement.textContent = "Info articolo " + data.nome;
                            }
                            if (ninvElement) {
                                ninvElement.textContent = "Numero inventario: " + data.numero_inventario;
                            }
                        }
                        
                        var popupElement = document.getElementById(popupId);
                        if (popupElement) {
                            popupElement.style.display = 'block';
                        } else {
                            console.error('Elemento con id ' + popupId + ' non trovato');
                        }
                        document.getElementById('popup-overlay').style.display = 'block';
                    }
                });
            });
        }
    }

        addClickListener(linksinfo, 'utenti-info.php',false,false, false,false,false,'popup-info');
        addClickListener(linksmod, 'utenti-info.php', true,false, false,false,false,'popup-mod'); 
        addClickListener(linksdelete, 'utenti-info.php',false, true, false,false,false,'popup-del'); 
        addClickListener(linksnew, 'utenti-info.php',false, false, true,false,false, 'popup-new'); 

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