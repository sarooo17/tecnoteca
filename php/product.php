<html>
<head>
    <meta charset="UTF-8" />
    <title>Saro</title>
    <link id="favicon" rel="icon" href="../img/logo/favicon.svg" />

    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/product.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    <section id="product">
        <?php
        
        require_once './db.php';

        $productId = $_GET['productid'];

        $sql = "SELECT * FROM articoli WHERE id_articolo= $productId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['id_articolo'];
                $productName = $row['nome'];
                $productDescription = $row['descrizione'];
                $productImg = $row['img'];
                $productColor = $row['colore'];
                $productPlace = $row['fk_centro'];
                $productType = $row['fk_categoria'];

                $sql = "SELECT nome FROM centri WHERE id_centro = $productPlace";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $centerName = $row['nome'];
                    }
                }

                $sql = "SELECT categoria FROM categorie WHERE id_categoria = $productType";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $categoryName = $row['categoria'];
                    }
                }
            }

            echo "<div class='row'>
                    <div class='col-desc'>
                        <div class='top'>
                            <p class='novità'>Novità</p>
                            <h1>".ucfirst($productName)."</h1>
                            <p class='categoria'>".ucfirst($categoryName)."</p>
                            <div class='color'>
                                <h3>Color :</h3>
                                <span style='--bg-color: #$productColor;'></span>
                            </div>
                            <p>".ucfirst($productDescription)."</p>
                        </div>
                        <div class='bottom'>
                            <div class='row-where'>
                                <div class='icon-position'><i class='bi bi-bag-heart pin-point'></i></div>
                                <div class='col-where'>
                                    <div><p>Prenota ora. Ritiro, in negozio:</p></div>
                                    <div><p>Oggi presso <a href='./php/map.php'>".ucfirst($centerName)."</a></p></div>
                                </div>
                            </div>";
                                $disabled = '';
                                if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'cliente') {
                                    $disabled = 'disabled';
                                }
            echo"               <form method='post' class='prenotazione-form' action='./nuova-prenotazione.php'>
                                <input type='text' id='datepickerButton' name='datepickerButton' placeholder='Seleziona le date' $disabled>
                                <input type='hidden' id='productId' name='productId' value='$productId'>
                                <div class='prenota'>
                                    <button type='submit' class='button-21' $disabled>Prenota e ritira</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class='col-img'>
                        <img src='../img/articoli/$productImg' />
                    </div>
                </div>";
        } else {
            echo "Product not found";
        }
        ?>
        
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
    document.querySelector('.prenotazione-form').addEventListener('submit', function(event) {
        var datepickerValue = document.querySelector('#datepickerButton').value;

        if (!datepickerValue) {
            alert('Per favore, seleziona una data di inizio e fine.');
            event.preventDefault();
        }
    });

    var productId = document.getElementById('productId').value;    

    $(document).ready(function() {
        $.ajax({
            url: './prenotazioni-info.php',
            type: 'POST',
            data: { productId: productId },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#datepickerButton').daterangepicker({
                    opens: 'right',
                    minDate: moment().add(1, 'days'),
                    maxDate: moment().add(6, 'months'),
                    drops: 'up',
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD/MM/YYYY',
                        cancelLabel: 'Clear',
                    },
                    isInvalidDate: function(date) {
                        for (var i = 0; i < data.length; i++) {
                            var start = moment(data[i].data_ritiro);
                            var end = moment(data[i].data_restituzione);

                            if (date.isBetween(start, end, null, '[]')) {
                                return true;
                            }
                        }
                        return false;
                    }
                });
                $('#datepickerButton').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                });

                $('#datepickerButton').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            }
        });

    });
</script>
</html>