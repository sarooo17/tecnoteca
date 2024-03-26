<html>
<head>
    <meta charset="UTF-8" />
    <title>Account</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/user.css">
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
    <?php
        if(isset($_SESSION['user_id'])) {

            require_once './db.php';

            $user_id = $_SESSION['user_id'];

            $sql = "SELECT * FROM utenti WHERE id_utente = $user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                $img = !empty($user['img']) ? '../img/users/'.$user['img'] : '../img/default/user.jpeg';
                $nome = $user['nome'];
                $cognome = $user['cognome'];
                $email = $user['email'];
                $indirizzo = $user['indirizzo'];

                echo '<section id="account">
                        <div class="user-profile">
                            <div class="user-profile-infos">
                                <div class="profile-img">
                                    <img src="'.$img.'" />
                                    <a href="javascript:void(0);" onclick="openPopup()">
                                        <div class="overlay">
                                            <i class="bi bi-pencil"></i>
                                        </div>
                                    </a>
                                    <div id="popup-overlay" style="display: none;"></div>
                                    <div id="popup" class="popup" style="display: none;">
                                        <div class="popup-content">
                                            <h3>Modifica foto profilo</h3>
                                            <span class="close" onclick="closePopup(event)">&times;</span>
                                            <form action="./edit_user_img.php" method="post" enctype="multipart/form-data">
                                                <div class="upload">
                                                    <label id="file-name"></label>
                                                </div>
                                                <label for="file-upload" class="custom-file-upload">Seleziona un file</label>
                                                <input id="file-upload" type="file" name="img"/>
                                                <button class="button-outline" role="button" type="submit">Carica</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <h1>'.ucfirst($nome).' '.ucfirst($cognome).'</h1>
                                    <p><strong>'.$email.'</strong></p>
                                </div>
                            </div>
                            <div class="profile-edit">
                                <button class="button-outline" role="button" onclick="openPopup()">Modifica foto profilo</button>
                            </div>
                        </div>
                        <div class="account-box">
                            <div class="account-box-title">
                                <h1>Info utente</h1>
                            </div>
                            <div class="line"></div>
                            <div class="account-box-line">
                                <div class="account-box-line-data">
                                    <p><strong>Nome utente</strong></p>
                                    <p id="pnome" style="display: block;">'.ucfirst($nome).' '.ucfirst($cognome).'</p>
                                </div>
                                <div class="account-box-line-arrow">
                                    <a href="javascript:void(0);" onclick="openFormNome()"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                            <form id="formnome" class="edit-form" action="./edit_user_name.php" style="display: none;" method="post">
                                <div class="inputs-form">
                                    <div class="input-form">
                                        <label for="nome"><strong>Nome</strong></label>
                                        <input type="text" id="nome" name="nome" placeholder="'.ucfirst($nome).'">
                                    </div>
                                    <div class="input-form">
                                        <label for="nome"><strong>Cognome</strong></label>
                                        <input type="text" id="cognome" name="cognome" placeholder="'.ucfirst($cognome).'">
                                    </div>
                                </div>
                                <div class="button-form">
                                    <div class="buttons">
                                        <button type="button" class="button-outline annulla" onclick="AnnullaFormNome()">Annulla</button>
                                        <button type="submit" class="button-outline conferma">Conferma</button>
                                    </div>
                                </div>
                            </form>
                            <div class="line"></div>
                            <div class="account-box-line">
                                <div class="account-box-line-data">
                                    <p><strong>Email</strong></p>
                                    <p id="pemail" style="display: block;">'.$email.'</p>
                                </div>
                                <div class="account-box-line-arrow">
                                    <a href="javascript:void(0);" onclick="openFormEmail()"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                            <form id="formemail" class="edit-form" action="./edit_user_email.php" style="display: none;" method="post">
                                <div class="inputs-form">
                                    <div class="input-form">
                                        <label for="email"><strong>Nuova email</strong></label>
                                        <input type="email" id="email" name="email" placeholder="'.$email.'">
                                    </div>
                                </div>
                                <div class="button-form">
                                    <div class="buttons">
                                        <button type="button" class="button-outline annulla" onclick="AnnullaFormEmail()">Annulla</button>
                                        <button type="submit" class="button-outline conferma">Conferma</button>
                                    </div>
                                </div>
                            </form>
                            <div class="line"></div>
                            <div class="account-box-line">
                                <div class="account-box-line-data">
                                    <p><strong>Password</strong></p>
                                    <p id="ppassword" style="display: block;">
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                        <i class="bi bi-dot"></i>
                                    </p>
                                </div>
                                <div class="account-box-line-arrow">
                                    <a href="javascript:void(0);" onclick="openFormPassword()"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                            <form id="formpassword" class="edit-form" action="./edit_user_password.php" style="display: none;" method="post">
                                <div class="inputs-form">
                                    <div class="input-form">
                                        <label for="old-password"><strong>Vecchia password</strong></label>
                                        <input type="password" id="old-password" name="old-password">
                                    </div>
                                    <div class="input-form">
                                        <label for="new-password"><strong>Nuova password</strong></label>
                                        <input type="password" id="new-password" name="new-password">
                                    </div>
                                    <div class="input-form">
                                        <label for="conf-password"><strong>Conferma password</strong></label>
                                        <input type="password" id="conf-password" name="conf-password">
                                    </div>
                                </div>
                                <div class="button-form">
                                    <div class="buttons">
                                        <button type="button" class="button-outline annulla" onclick="AnnullaFormPassword()">Annulla</button>
                                        <button type="submit" class="button-outline conferma">Conferma</button>
                                    </div>
                                </div>
                            </form>
                            <div class="line"></div>
                            <div class="account-box-line">
                                <div class="account-box-line-data">
                                    <p><strong>Indirizzo</strong></p>
                                    <p id="pindirizzo" style="display: block;">'.$indirizzo.'</p>
                                </div>
                                <div class="account-box-line-arrow">
                                    <a href="javascript:void(0);" onclick="openFormIndirizzo()"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                            <form id="formindirizzo" class="edit-form" action="./edit_user_indirizzo.php" style="display: none;" method="post">
                                <div class="inputs-form">
                                    <div class="input-form">
                                        <label for="indirizzo"><strong>Nuovo indirizzo</strong></label>
                                        <input type="text" id="indirizzo" name="indirizzo" placeholder="'.$indirizzo.'">
                                    </div>
                                </div>
                                <div class="button-form">
                                    <div class="buttons">
                                        <button type="button" class="button-outline annulla" onclick="AnnullaFormIndirizzo()">Annulla</button>
                                        <button type="submit" class="button-outline conferma">Conferma</button>
                                    </div>
                                </div>
                            </form>
                            <div class="line"></div>
                            <div class="account-box-line">
                                <div class="account-box-line-data">
                                    <p><strong>Prenotazioni e Prestiti</strong></p>
                                </div>
                                <div class="account-box-line-arrow">
                                    <a href="./prestitiprenotazioni.php"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <a href="./logout.php" class="exit" role="button"><strong>Esci</strong></a>
                    </section>';
            } else {
                echo "Nessun utente trovato con l'ID: $user_id";
            }
        } else {
            echo '<section id="account">
                    <div class="account-box">
                        <div class="account-box-title">
                            <h1>Accedi</h1>
                        </div>
                        <div class="account-box-button">
                            <button class="button-21" role="button" onclick="window.location.href=\'./login.php\'">Accedi</button>
                            <button class="button-21" role="button" onclick="window.location.href=\'./signin.php\'">Registrati</button>
                        </div>
                    </div>
                </section>';
        }
    ?>
</body>
<script>
    function openPopup() {
        document.getElementById('popup-overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block'
    }

    function openFormNome() {
        document.getElementById('formnome').style.display = 'block';
        document.getElementById('pindirizzo').style.display = 'block';
        document.getElementById('pemail').style.display = 'block';
        document.getElementById('ppassword').style.display = 'block';
        document.getElementById('formindirizzo').style.display = 'none';
        document.getElementById('formemail').style.display = 'none';
        document.getElementById('formpassword').style.display = 'none';
        document.getElementById('pnome').style.display = 'none';
    }

    function AnnullaFormNome() {
        document.getElementById('formnome').style.display = 'none';
        document.getElementById('pnome').style.display = 'block';

        document.getElementById('nome').value = "";
        document.getElementById('cognome').value = "";
    }

    function openFormEmail() {
        document.getElementById('formemail').style.display = 'block';
        document.getElementById('pnome').style.display = 'block';
        document.getElementById('pindirizzo').style.display = 'block';
        document.getElementById('ppassword').style.display = 'block';
        document.getElementById('formnome').style.display = 'none';
        document.getElementById('formindirizzo').style.display = 'none';
        document.getElementById('formpassword').style.display = 'none';
        document.getElementById('pemail').style.display = 'none';
    }

    function AnnullaFormEmail() {
        document.getElementById('formemail').style.display = 'none';
        document.getElementById('pemail').style.display = 'block';

        document.getElementById('email').value = "";
    }

    function openFormPassword() {
        document.getElementById('formpassword').style.display = 'block';
        document.getElementById('pnome').style.display = 'block';
        document.getElementById('pemail').style.display = 'block';
        document.getElementById('pindirizzo').style.display = 'block';
        document.getElementById('formnome').style.display = 'none';
        document.getElementById('formemail').style.display = 'none';
        document.getElementById('formindirizzo').style.display = 'none';
        document.getElementById('ppassword').style.display = 'none';
    }

    function AnnullaFormPassword() {
        document.getElementById('formpassword').style.display = 'none';
        document.getElementById('ppassword').style.display = 'block';

        document.getElementById('password').value = "";
    }

    function openFormIndirizzo() {
        document.getElementById('formindirizzo').style.display = 'block';
        document.getElementById('pnome').style.display = 'block';
        document.getElementById('pemail').style.display = 'block';
        document.getElementById('ppassword').style.display = 'block';
        document.getElementById('formnome').style.display = 'none';
        document.getElementById('formemail').style.display = 'none';
        document.getElementById('formpassword').style.display = 'none';
        document.getElementById('pindirizzo').style.display = 'none';
    }

    function AnnullaFormIndirizzo() {
        document.getElementById('formindirizzo').style.display = 'none';
        document.getElementById('pindirizzo').style.display = 'block';

        document.getElementById('indirizzo').value = "";
    }

    function closePopup(event) {
        if (event.target.className == 'close') {
            document.getElementById('popup-overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    }

    document.getElementById('file-upload').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        document.getElementById('file-name').textContent = fileName;
    });
</script>
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