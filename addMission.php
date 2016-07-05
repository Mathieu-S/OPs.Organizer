<!DOCTYPE html>
<html lang="fr">
<head>
    <head>
        <meta charset="UTF-8">

        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/custom.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/helper.css"  media="screen,projection"/>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
</head>

<body>
    <header class="hlp-bottom-m">
        <?php
        require("functions/functions.php");
        session_start();
        $missions = getMissions();

        var_dump($_SESSION);
        ?>

        <h1 class="center-align font-purista"><b>OPs. ORGANIZER</b></h1>

        <nav class="container">
            <div class="row">
                <div class="col s4 center"><a class="font-purista" href="index.php">ACCEUIL</a></div>
                <div class="col s4 center"><a class="font-purista" href="addMission.php">CRÉÉ UNE MISSION</a></div>
                <div class="col s4 center"><a class="font-purista" href="login.php">S'INSCRIRE/SE CONNECTER</a></div>
            </div>
        </nav>
    </header>

    <section class="container hlp-bottom-l">
        <div class="row">
            <div class="col s12">This div is 12-columns wide</div>
            <div class="col s6">This div is 6-columns wide</div>
            <div class="col s6">This div is 6-columns wide</div>
        </div>
    </section>

    <footer class="page-footer" style="padding-top: -20px;">
        <div class="footer-copyright">
            <div class="container">
                © 2016 Copyright SinTeam Gaming
                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
        </div>
    </footer>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').material_select();
            $('.modal-trigger').leanModal();
            $('.tooltipped').tooltip({delay: 50});
        });
    </script>
</body>

</html>