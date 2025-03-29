<?php
    /*template*/
    function template_header($title) {
    echo <<<EOT
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>$title</title>
                <link  rel="stylesheet" href="css/style.css">
                <link rel="stylesheet" href="css/fontawesome/all.css">
            </head>
            <body>
            <nav class="navtop">
                <div>
                    <h1>JIRAMA</h1>
                    <a href="index.php"><i class="fas fa-home"></i>Tableau du board</a>
                    <a href="clients.php"><i class="fas fa-address-book"></i>Clients</a>
                    <a href="compteurs.php"><i class="fas fa-address-book"></i>Compteurs</a>
                    <a href="releves.php"><i class="fas fa-address-book"></i>Rélevés</a>
                    <a href="paiements.php"><i class="fas fa-address-book"></i>Paiements</a>
                </div>
            </nav>
        EOT;
    }

    function template_footer() {
        echo <<<EOT
            </body>
        </html>
        EOT;
    }
?>