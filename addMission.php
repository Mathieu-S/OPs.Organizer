<?php
require("functions/functions.php");
session_start();
$missions = getMissions();

var_dump($_SESSION);
var_dump($_POST);

if(isset($_GET['logout'])) {
    session_destroy();
    header("location:index.php");
}

//Déverouille l'onget inscription si loged
$isLoged = "disabled";
if (isset($_SESSION['id'])) {
    $isLoged = "";
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
    <link href="css/nouislider.css" rel="stylesheet">
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
                <div class="col s4 center"><a class="font-purista" href="login.php">S'INSCRIRE/SE CONNECTER</a></div>
            </div>
        </nav>
    </header>

    <section class="container hlp-bottom-l">
        <form class="card" method="post">
            <div class="card-content">
                <h4 class="font-purista center-align">CRÉÉ UNE MISSION</h4>

                <div class="row">
                    <div class="col s12 m6 offset-m3">
                        <div class="input-field">
                            <input name="nomMission" id="nomMission" type="text" class="validate">
                            <label for="nomMission">Nom de la mission</label>
                        </div>
                    </div>

                    <div class="col s12 m4">
                        <div class="input-field">
                            <select name="faction" id="faction">
                                <option value="" disabled selected>Choisissez une faction</option>
                                <option value="1">Nato</option>
                                <option value="2">CSAT</option>
                                <option value="3">AAF</option>
                            </select>
                            <label for="faction">Faction jouer</label>
                        </div>
                    </div>

                    <div class="col s12 m4">
                        <div class="input-field">
                            <select name="localisation" id="localisation">
                                <option value="" disabled selected>Choisissez une localisation</option>
                                <option value="1">Stratis</option>
                                <option value="2">Altis</option>
                                <option value="3">Tanoa</option>
                            </select>
                            <label for="localisation">Localisation</label>
                        </div>
                    </div>

                    <div class="col s12 m4">
                        <div class="input-field">
                            <input name="date" type="text" class="datepicker">
                            <label for="date">Date</label>
                        </div>
                    </div>
                </div>

                <p class="grey-text hlp-bottom-l">Nombre de joueur nécéssaire</p>
                <div class="hlp-bottom-m" id="nbRqPlayer">
                    <input name="minPlayers" id="minPlayers" type="number" hidden>
                    <input name="maxPlayers" id="maxPlayers" type="number" hidden>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <textarea name="situation" id="situation" class="materialize-textarea"></textarea>
                        <label for="situation">Situation</label>
                    </div>

                    <div class="input-field col s12">
                        <textarea name="objetctif" id="objetctif" class="materialize-textarea"></textarea>
                        <label for="objetctif">Objetctif</label>
                    </div>
                </div>
            </div>

            <div class="card-action center-align">
                <button class="btn waves-effect waves-light" type="submit">Créér la mission
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
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
    <script src="js/nouislider.js"></script>
    <script>
        $(document).ready(function() {
            $('select').material_select();
            $('.modal-trigger').leanModal();
            $('.tooltipped').tooltip({delay: 50});
        });
    </script>

    <script>
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15 // Creates a dropdown of 15 years to control year
        });
    </script>

    <script>
        var slider = document.getElementById('nbRqPlayer');
        noUiSlider.create(slider, {
            start: [20, 80],
            connect: true,
            step: 1,
            range: {
                'min': 0,
                'max': 100
            },
            format: wNumb({
                decimals: 0
            })
        });
    </script>

    <script>
        var minPlayers = document.getElementById('minPlayers');
        var maxPlayers = document.getElementById('maxPlayers');

        slider.noUiSlider.on('update', function( values, handle ) {

            var value = values[handle];

            if ( handle ) {
                maxPlayers.value = value;
            } else {
                minPlayers.value = value;
            }
        });

        minPlayer.addEventListener('change', function(){
            slider.noUiSlider.set([this.value, null]);
        });

        maxPlayer.addEventListener('change', function(){
            slider.noUiSlider.set([null, this.value]);
        });
    </script>
</body>

</html>