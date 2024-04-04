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
        <title>Saro Articoli</title>
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
        <section>
            <div class="col-art-back">
                <div class="row-art-back">
                    <div class="box">
                        <div class="box-title art">
                                <i class="bi bi-box-seam icon-title"></i>
                                <h1>Articoli</h1>
                        </div>
                        <div class="line"></div>
                        <div class="box-data top-tab">
                            <p><u><strong>Numero inventario</strong></u></p>
                            <p><u><strong>Nome</strong></u></p>
                            <p><u><strong>Centro</strong></u></p>
                            <p><u><strong>Stato</strong></u></p>
                            <div class="btns">
                                <a href="#" class="open-popup-new">
                                    <i class="bi bi-plus"></i>
                                </a>
                                <a href="?filter=old" class="open-popup-old">
                                    <i class="bi-x-circle"></i>
                                </a>
                                <a href="?filter=" class="open-popup-art">
                                    <i class="bi bi-boxes"></i>
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

                            $table = "articoli";

                            if (isset($_GET['filter'])) {
                                $filter = $_GET['filter'];

                                if ($filter === 'old') {
                                    $table = "articoli_eliminati";
                                }
                            }

                            $sql = "SELECT * FROM " . $table;

                            if ($_SESSION['user_type'] == 'operatore') {
                                $operator_centroid = $_SESSION['operator_centroid'];
                                $sql .= " WHERE fk_centro = " . $operator_centroid;
                            }

                            $result = $conn->query($sql);

                            if ($result === false) {
                                die("Errore nell'esecuzione della query: " . $conn->error);
                            }

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $numero_inventario = $row["numero_inventario"];
                                    $nome = $row["nome"];
                                    $stato = $row["stato"];
                                    $centroid = $row["fk_centro"];

                                    $descrizione = $row["descrizione"];
                                    $categoriaid = $row["fk_categoria"];
                                    $colore = $row["colore"];
                                    $img = $row["img"];

                                    $sql_category = "SELECT * FROM categorie WHERE id_categoria = $categoriaid";
                                    $result_category = $conn->query($sql_category);

                                    if ($result_category->num_rows > 0) {
                                        while($row_category = $result_category->fetch_assoc()) {
                                            $categoria = $row_category["categoria"];
                                            $tipologia = $row_category["tipologia"];
                                        }
                                    } else {
                                        $categoria = "No category found";
                                    }

                                    $sql_centro = "SELECT * FROM centri WHERE id_centro = $centroid";
                                    $result_centro = $conn->query($sql_centro);

                                    if ($result_centro->num_rows > 0) {
                                        while($row_centro = $result_centro->fetch_assoc()) {
                                            $centro = $row_centro["nome"];
                                        }
                                    } else {
                                        $centro = "No center found";
                                    }
                                    
                                    echo '<div class="box-data">
                                            <div class="articolo">
                                                <p><strong>'.$numero_inventario.'</strong></p>
                                                <p>'.ucfirst($nome).'</p>
                                                <p>'.ucfirst($centro).'</p>';
                                                if($stato == "disponibile"){
                                                    echo '<p class="disponibile">'.ucfirst($stato).'</p>';
                                                }else if($stato == "in prestito"){
                                                    echo '<p class="in-prestito">'.ucfirst($stato).'</p>';
                                                }else if($stato == "guasto"){
                                                    echo '<p class="guasto">'.ucfirst($stato).'</p>';
                                                }
                                echo '</div>';
                                    if ($table !== 'articoli_eliminati') {
                                        echo '<div class="btns">
                                                <div id="popup-overlay" style="display: none;"></div>
                                                <a href="#" class="open-popup-info" data-id="'.$numero_inventario.'">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <div id="popup-info" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                        <h3 id="titolo-popup"></h3>
                                                        <span class="close" onclick="closePopup(event, \'popup-info\')">&times;</span>                                                        
                                                        <p id="nome-popup"></p>
                                                        <p id="numero_inventario-popup"></p>
                                                        <p id="categoria-popup"></p>
                                                        <p id="centro-popup"></p>
                                                        <p id="stato-popup"></p>
                                                        <p id="descrizione-popup"></p>
                                                        <p id="colore-popup"></p>
                                                        <p id="tipologia-popup"></p>
                                                        <p id="indirizzo-popup"></p>
                                                    </div>
                                                </div>
                                                <a href="#" class="open-popup-mod" data-id="'.$numero_inventario.'">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <div id="popup-mod" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                    </div>
                                                </div>
                                                <a href="#" class="open-popup-delete" data-id="'.$numero_inventario.'">
                                                    <i class="bi bi-trash trash"></i>
                                                </a>
                                                <div id="popup-del" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }else{
                                        echo '<div class="btns">
                                                <div id="popup-overlay" style="display: none;"></div>
                                                <a href="#" class="open-popup-rest" data-id="'.$numero_inventario.'">
                                                    <i class="bi bi-box-arrow-up-left"></i>
                                                </a>
                                                <div id="popup-rest" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                    </div>
                                                </div>
                                                <a href="#" class="open-popup-delete-def" data-id="'.$numero_inventario.'">
                                                    <i class="bi bi-trash trash"></i>
                                                </a>
                                                <div id="popup-del-def" class="popup" style="display: none;">
                                                    <div class="popup-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                    
                                    echo'<div class="line"></div>';
                                }
                            } else {
                                echo "<div class='no-data'><strong><p>Nessun articolo trovato</p></strong></div>";
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
        var linksrest = document.querySelectorAll('.open-popup-rest');
        var linksdeldef = document.querySelectorAll('.open-popup-delete-def');

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
                        var ninvElement = document.getElementById('numero_inventario-popup');
                        var categoriaElement = document.getElementById('categoria-popup');
                        var centroElement = document.getElementById('centro-popup');
                        var statoElement = document.getElementById('stato-popup');
                        var descrizioneElement = document.getElementById('descrizione-popup');
                        var imgElement = document.getElementById('img-popup');
                        var coloreElement = document.getElementById('colore-popup');
                        var tipologiaElement = document.getElementById('tipologia-popup');
                        var indirizzoElement = document.getElementById('indirizzo-popup');

                        if (isMod) {
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-mod\')">&times;</span>';
                            formHtml += '<form action="modifica-articolo.php" method="post">';
                            formHtml += '<h3>Modifica articolo ' + data.nome + '</h3>';
                            formHtml += '<input type="hidden" name="id" value="' + data.id + '">';
                            formHtml += '<input type="text" name="nome" value="' + data.nome + '">';
                            formHtml += '<input type="text" name="numero_inventario" value="' + data.numero_inventario + '">';
                            formHtml += '<input type="text" name="categoria" value="' + data.categoria + '">';
                            formHtml += '<input type="text" name="nome_centro" value="' + data.nome_centro + '">';
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
                            formHtml += '<form action="articoli-delete.php" method="post">';
                            formHtml += '<h3>Sei sicuro di voler eliminare l\'articolo ' + data.nome + '('+data.numero_inventario+')?</h3>';
                            formHtml += '<input type="hidden" name="id" value="' + data.id + '">';
                            formHtml += '<input type="submit" value="Elimina">';
                            formHtml += '</form>';

                            document.getElementById('popup-del').querySelector('.popup-content').innerHTML = formHtml;
                        } else if(isNew){
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-new\')">&times;</span>';
                            formHtml += '<form action="nuovo-articolo.php" method="post">';
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
                        } else if(isRest){
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-rest\')">&times;</span>';
                            formHtml += '<form action="articoli-restore.php" method="post">';
                            formHtml += '<h3>Sei sicuro di voler ripristinare l\'articolo ' + data.nome + '('+data.numero_inventario+')?</h3>';
                            formHtml += '<input type="hidden" name="id" value="' + data.id + '">';
                            formHtml += '<input type="submit" value="Ripreistina">';
                            formHtml += '</form>';

                            document.getElementById('popup-rest').querySelector('.popup-content').innerHTML = formHtml;
                        } else if(isDelDef){
                            var formHtml = '<span class="close" onclick="closePopup(event, \'popup-del-def\')">&times;</span>';
                            formHtml += '<form action="articoli-delete-def.php" method="post">';
                            formHtml += '<h3>Sei sicuro di voler eliminare definitivamente l\'articolo ' + data.nome + '('+data.numero_inventario+')?</h3>';
                            formHtml += '<input type="hidden" name="id" value="' + data.id + '">';
                            formHtml += '<input type="submit" value="Elimina">';
                            formHtml += '</form>';

                            document.getElementById('popup-del-def').querySelector('.popup-content').innerHTML = formHtml;
                        } else {
                            if (nomeElement) {
                                nomeElement.textContent = "Info articolo " + data.nome;
                            }
                            if (ninvElement) {
                                ninvElement.textContent = "Numero inventario: " + data.numero_inventario;
                            }
                            if (categoriaElement) {
                                categoriaElement.textContent = "Categoria: " + data.categoria;
                            }
                            if (centroElement) {
                                centroElement.textContent = "Centro: " + data.nome_centro;
                            }
                            if (statoElement) {
                                statoElement.textContent = "Stato: " + data.stato;
                            }
                            if (descrizioneElement) {
                                descrizioneElement.textContent = "Descrizione: " + data.descrizione;
                            }
                            if (coloreElement) {
                                coloreElement.textContent = "Colore: " + data.colore;
                            }
                            if (tipologiaElement) {
                                tipologiaElement.textContent = "Tipologia: " + data.tipologia;
                            }
                            if (indirizzoElement) {
                                indirizzoElement.textContent = "Indirizzo: " + data.indirizzo;
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

        addClickListener(linksinfo, 'articoli-info.php',false,false, false,false,false,'popup-info');
        addClickListener(linksmod, 'articoli-info.php', true,false, false,false,false,'popup-mod'); 
        addClickListener(linksdelete, 'articoli-info.php',false, true, false,false,false,'popup-del'); 
        addClickListener(linksnew, 'articoli-info.php',false, false, true,false,false, 'popup-new'); 
        addClickListener(linksrest, 'articoli-info-elimina.php',false, false, false,true,false, 'popup-rest'); 
        addClickListener(linksdeldef, 'articoli-info-elimina.php',false, false, false,false,true, 'popup-del-def'); 

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