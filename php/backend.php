<html>
    <head>
        <title>Saro tecnoteca Backend</title>
        <link id="favicon" rel="icon" href="./img/logo/favicon.svg" />

        <link rel="stylesheet" type="text/css" href="../css/backend.css">
        <link rel="stylesheet" type="text/css" href="../css/general.css">
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
                <div class="row r1">
                    <div class="box">
                        <div class="box-title">
                            <h1>Articoli</h1>
                            <div class="account-box-line-arrow">
                                <a href="./articoli-backend.php"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="line"></div>
                        
                    </div>
                    <div class="box c2">
                        <div class="box-title">
                            <h1>Prestiti</h1>
                            <div class="account-box-line-arrow">
                                <a href="./prestiti-backend.php"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="box">
                        <div class="box-title">
                            <h1>Prenotazioni</h1>
                            <div class="account-box-line-arrow">
                                <a href="./prenotazioni-backend.php"><i class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="line"></div>
                    </div>
                    <?php
                        if ($_SESSION['user_type'] === 'admin') {
                            echo '<div class="box c2">
                                    <div class="box-title">
                                        <h1>Utenti</h1>
                                        <div class="account-box-line-arrow">
                                            <a href="./utenti-backend.php"><i class="bi bi-chevron-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                </div>';
                        }
                    ?>	
                </div>
            </div>
        </section>
    </body>
</html>