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
        <title>Saro tecnoteca Backend</title>
        <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

        <link rel="stylesheet" type="text/css" href="../css/backend.css">
        <link rel="stylesheet" type="text/css" href="../css/general.css">

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
            <div class="col">
                <div class="row r1">
                    <div class="box" id="box-articoli" style="cursor: pointer;">
                        <div class="box-title">
                            <h1>Articoli</h1>
                            <div class="account-box-line-arrow">
                                <a href="./articoli-backend.php"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="records-table" id="articoli">

                        </div>
                    </div>
                    <div class="box c2" id="box-prestiti" style="cursor: pointer;">
                        <div class="box-title">
                            <h1>Prestiti</h1>
                            <div class="account-box-line-arrow">
                                <a href="./prestiti-backend.php"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="records-table" id="prestiti">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box" id="box-prenotazioni" style="cursor: pointer;">
                        <div class="box-title">
                            <h1>Prenotazioni</h1>
                            <div class="account-box-line-arrow">
                                <a href="./prenotazioni-backend.php"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="records-table" id="prenotazioni">

                        </div>
                    </div>
                    <?php
                        if ($_SESSION['user_type'] === 'admin') {
                            echo '<div class="box c2" id="box-utenti" style="cursor: pointer;">
                                    <div class="box-title">
                                        <h1>Utenti</h1>
                                        <div class="account-box-line-arrow">
                                            <a href="./utenti-backend.php"><i class="bi bi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="records-table" id="users">

                                    </div>
                                </div>';
                        }
                    ?>	
                </div>
            </div>
        </section>
    </body>
    <script>
        $('#box-articoli').on('click', function() {
            window.location.href = './articoli-backend.php';
        });
        $('#box-prenotazioni').on('click', function() {
            window.location.href = './prenotazioni-backend.php';
        });
        $('#box-prestiti').on('click', function() {
            window.location.href = './prestiti-backend.php';
        });
        $('#box-utenti').on('click', function() {
            window.location.href = './utenti-backend.php';
        });

        var Heightusers = $('#users').height();
        var Heightarticoli = $('#articoli').height();
        var Heightprestiti = $('#prestiti').height();
        var Heightprenotazioni = $('#prenotazioni').height();

        $.ajax({
            url: 'get_articoli.php',
            method: 'POST',
            data: { height: Heightarticoli},
            success: function(response) {
                var articoli = JSON.parse(response);
                var html = '';
                for (var i = 0; i < articoli.length; i++) {
                    html += articoli[i];
                }
                $('#articoli').html(html);
            },
            error: function(jqXHR) {
                if (jqXHR.status == 404) {
                    $('#articoli').html('<div class="no-data"><strong><p>Nessun articolo trovato</p></strong></div>');
                }
            }
        });

        $.ajax({
            url: 'get_users.php',
            method: 'POST',
            data: { height: Heightusers},
            success: function(response) {
                var users = JSON.parse(response);
                var html = '';
                for (var i = 0; i < users.length; i++) {
                    html += users[i];
                }
                $('#users').html(html);
            },
            error: function(jqXHR) {
                if (jqXHR.status == 404) {
                    $('#users').html('<div class="no-data"><strong><p>Nessun utente trovato</p></strong></div>');
                }
            }
        });

        $.ajax({
            url: 'get_prestiti.php',
            method: 'POST',
            data: { height: Heightprestiti},
            success: function(response) {
                var prestiti = JSON.parse(response);
                var html = '';
                for (var i = 0; i < prestiti.length; i++) {
                    html += prestiti[i];
                }
                $('#prestiti').html(html);
            },
            error: function(jqXHR) {
                if (jqXHR.status == 404) {
                    $('#prestiti').html('<div class="no-data"><strong><p>Nessun prestito trovato</p></strong></div>');
                }
            }
        });

        $.ajax({
            url: 'get_prenotazioni.php',
            method: 'POST',
            data: { height: Heightprenotazioni},
            success: function(response) {
                var prenotazioni = JSON.parse(response);
                var html = '';
                for (var i = 0; i < prenotazioni.length; i++) {
                    html += prenotazioni[i];
                }
                $('#prenotazioni').html(html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 404) {
                    $('#prenotazioni').html('<div class="no-data"><strong><p>Nessuna prenotazione trovata</p></strong></div>');
                }
            }
        });

        $(window).on('resize', function() {
            var Heightusers = $('#users').height();
            var Heightarticoli = $('#articoli').height();
            var Heightprestiti = $('#prestiti').height();
            var Heightprenotazioni = $('#prenotazioni').height();

            $.ajax({
                url: 'get_articoli.php',
                method: 'POST',
                data: { height: Heightarticoli},
                success: function(response) {
                    var articoli = JSON.parse(response);
                    var html = '';
                    for (var i = 0; i < articoli.length; i++) {
                        html += articoli[i];
                    }
                    $('#articoli').html(html);
                }
            });

            $.ajax({
                url: 'get_users.php',
                method: 'POST',
                data: { height: Heightusers},
                success: function(response) {
                    var users = JSON.parse(response);
                    var html = '';
                    for (var i = 0; i < users.length; i++) {
                        html += users[i];
                    }
                    $('#users').html(html);
                }
            });

            $.ajax({
                url: 'get_prestiti.php',
                method: 'POST',
                data: { height: Heightprestiti},
                success: function(response) {
                    var prestiti = JSON.parse(response);
                    var html = '';
                    for (var i = 0; i < prestiti.length; i++) {
                        html += prestiti[i];
                    }
                    $('#prestiti').html(html);
                }
            });

            $.ajax({
                url: 'get_prenotazioni.php',
                method: 'POST',
                data: { height: Heightprenotazioni},
                success: function(response) {
                    var prenotazioni = JSON.parse(response);
                    var html = '';
                    for (var i = 0; i < prenotazioni.length; i++) {
                        html += prenotazioni[i];
                    }
                    $('#prenotazioni').html(html);
                }
            });
        });
    </script>
</html>