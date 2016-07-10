<?php
require("functions/functions.php");
session_start();
$script = "";

if (isset($_GET['logout'])) {
    session_destroy();
    header("location:index.php");
} elseif (array_key_exists('INS',$_POST)) {
    $script = "<script>Materialize.toast('Le pseudo ou l\'email est déjà utilisé', 4000)</script>";
    if (addUser()) {
        $script = "<script>Materialize.toast('Une erreur inatendu c\'est produite. Veuillez contacter SPG', 4000)</script>";
        if (connectUser()) {
            header("location:index.php");
        }
    }
} elseif (array_key_exists('CNX',$_POST)) {
    $script = "<script>Materialize.toast('Mot de passe invalide !', 4000)</script>";
    if (connectUser()) {
        header("location:index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
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

<body>
    <header class="hlp-bottom-m">
        <h1 class="center-align font-purista"><b>OPs. ORGANIZER</b></h1>

        <nav class="container">
            <div class="row">
                <div class="col s4 center"><a class="font-purista" href="index.php">ACCEUIL</a></div>
                <div class="col s4 center"><a class="font-purista" href="addMission.php">CRÉÉ UNE MISSION</a></div>
                <?php
                if (array_key_exists('id',$_SESSION)) {
                    ?><div class="col s4 center"><a class="font-purista" href="login.php?logout">SE DECONNECTER</a></div><?php
                } else {
                    ?><div class="col s4 center"><a class="font-purista" href="login.php">S'INSCRIRE/SE CONNECTER</a></div><?php
                }
                ?>
            </div>
        </nav>
    </header>

    <section class="container hlp-bottom-l">
        <div class="row">
            <div class="col s12 m6">
                <form class="card" method="post">
                    <div class="card-content container">
                        <h4 class="font-purista center-align hlp-bottom-m">S'INSCRIRE</h4>
                        <div class="input-field">
                            <i class="material-icons prefix">person</i>
                            <input required id="pseudo" name="pseudo" type="text" class="validate">
                            <label for="pseudo">Pseudo</label>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input required id="mdp" name="mdp" type="password" class="validate">
                            <label for="mdp">Password</label>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">mail</i>
                            <input required id="email" name="email" type="email" class="validate">
                            <label for="email" data-error="Email invalide" data-success="right">Email</label>
                        </div>
                    </div>

                    <div class="card-action center-align">
                        <button class="btn waves-effect waves-light" type="submit" name="INS" value="true">Valider
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col s12 m6">
                <form class="card" method="post">
                    <div class="card-content container">
                        <h4 class="font-purista center-align hlp-bottom-m">SE CONNECTER</h4>
                        <div class="input-field">
                            <i class="material-icons prefix">person</i>
                            <input required id="pseudo" name="pseudo" type="text" class="validate">
                            <label for="pseudo">Pseudo</label>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input required id="mdp" name="mdp" type="password" class="validate">
                            <label for="mdp">Password</label>
                        </div>
                    </div>

                    <div class="card-action center-align">
                        <button class="btn waves-effect waves-light" type="submit" name="CNX" value="true">Valider
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
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
    <?= $script;?>
</body>

</html>