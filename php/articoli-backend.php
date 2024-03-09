<html>
    <head>
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
            <div class="col">
                <div class="row">
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
                            <div class="btns"><span class="blank"></span></div>
                        </div>
                        <div class="line"></div>
                        <?php
                        require_once('./db.php');

                        $sql = "SELECT * FROM articoli";
                        $result = $conn->query($sql);

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
                                echo '  </div>
                                        <div class="btns">
                                            <div id="popup-overlay" style="display: none;"></div>
                                            <a href="#" class="open-popup-info" data-id="'.$numero_inventario.'">
                                                <i class="bi bi-three-dots"></i>
                                            </a>
                                            <div id="popup" style="display: none;">
                                                <div class="popup-content">
                                                    <h3></h3>
                                                    <span class="close" onclick="closePopup(event)">&times;</span>
                                                    <p></p>
                                                    <p></p>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <a href="#" class="open-popup-mod" data-id="'.$numero_inventario.'">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <div id="popup" style="display: none;">
                                                <div class="popup-content">
                                                    <h3></h3>
                                                    <span class="close" onclick="closePopup(event)">&times;</span>
                                                    <p></p>
                                                    <p></p>
                                                    <p></p>
                                                </div>
                                            </div><a href="#" class="open-popup-delete" data-id="'.$numero_inventario.'">
                                                <i class="bi bi-trash trash"></i>
                                            </a>
                                            <div id="popup" style="display: none;">
                                                <div class="popup-content">
                                                    <h3></h3>
                                                    <span class="close" onclick="closePopup(event)">&times;</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="line"></div>';
                            }
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                        
                            
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <script>
        var linksinfo = document.querySelectorAll('.open-popup-info');
        var linksmod = document.querySelectorAll('.open-popup-mod');
        var linksdelete = document.querySelectorAll('.open-popup-delete');

        function addClickListener(links, url) {
            for (var i = 0; i < links.length; i++) {
                links[i].addEventListener('click', function(event) {
                    event.preventDefault();

                    var id = this.getAttribute('data-id');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data.nome) {
                                document.querySelector('.popup-content h3').textContent = 'Articolo ' + data.nome;
                            }
                            if (data.info1) {
                                document.querySelector('.popup-content p:nth-child(2)').textContent = data.info1;
                            }
                            if (data.info2) {
                                document.querySelector('.popup-content p:nth-child(3)').textContent = data.info2;
                            }
                            if (data.info3) {
                                document.querySelector('.popup-content p:nth-child(4)').textContent = data.info3;
                            }

                            document.getElementById('popup').style.display = 'block';
                            document.getElementById('popup-overlay').style.display = 'block';
                        }
                    });
                });
            }
        }

        addClickListener(linksinfo, 'articoli-info.php');
        addClickListener(linksmod, 'articoli-info.php'); 
        addClickListener(linksdelete, 'articoli-delete.php'); 

        function closePopup(event) {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
        }
    </script>
</html>