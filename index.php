<?php
require("functions/functions.php");
session_start();
$missions = getMissions();
$script = "";

//Déconnecte l'utilisateur si la page à un GET logout
if(isset($_GET['logout'])) {
    session_destroy();
    header("location:index.php");

//Affiche un avertissement si l'utilisateur à voulu créer une mission avec une habilitaion trop basse
} elseif (isset($_GET['noAcces'])) {
    $script = "<script>Materialize.toast('Votre niveau d\'habilitation est trop faible pour pouvoir créer une mission.', 4000)</script>";
} elseif (isset($_GET['noLoged'])) {
    $script = "<script>Materialize.toast('Vous devez être connecter pour créer une mission', 4000)</script>";


} elseif (isset($_POST['INS'])) {
    inscriptionMission();
}



//Déverouille l'onget inscription si loged
$isLoged = "disabled";
if (isset($_SESSION['idPlayer'])) {
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
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
    <header class="hlp-bottom-m">
        <h1 class="center-align font-purista"><b>OPs. ORGANIZER</b></h1>

        <nav class="container">
            <div class="row">
                <div class="col s4 center"><a class="font-purista" href="index.php">ACCEUIL</a></div>
                <div class="col s4 center"><a class="font-purista" href="addMission.php">CRÉÉR UNE MISSION</a></div>
                <?php
                if (!array_key_exists('idPlayer',$_SESSION) OR empty($_SESSION['idPlayer'])) {
                    ?><div class="col s4 center"><a class="font-purista" href="login.php">S'INSCRIRE/SE CONNECTER</a></div><?php
                } else {
                    ?><div class="col s4 center"><a class="font-purista" href="login.php?logout">SE DECONNECTER</a></div><?php
                }
                ?>
            </div>
        </nav>
    </header>

    <section class="container hlp-bottom-l">
        <ul class="collapsible popout" data-collapsible="accordion">
            <?php foreach ($missions as $mission) { ?>
            <li>
                <!--Cadre mission-->
                <div class="collapsible-header">
                    <div class="row no-row">
                        <div class="col s12 m3 l2"><div>Etat : <?php echo($mission['date']); ?></div></div>
                        <div class="col s12 m5 l8"><div class="center-align">Nom : <?php echo($mission['nom']); ?></div></div>
                        <div class="col s6 m2 l1"><i style="margin-right: 0px;" class="material-icons">group</i>: <?php echo($mission['nbRqMinPlayer']); ?>-<?php echo($mission['nbRqMaxPlayer']); ?></div>
                        <div class="col s6 m2 l1"><i style="margin-right: 0px;" class="material-icons">person</i>: <?php echo($mission['nbInsPlayer']); ?></div>
                    </div>
                </div>

                <!--Contenue de la mission-->
                <div class="collapsible-body">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col s3"><a class="font-purista active" href="#briefing<?php echo($mission['id']); ?>">Briefing</a></li>
                                <li class="tab col s3"><a class="font-purista" href="#escouades<?php echo($mission['id']); ?>">Escouades</a></li>
                                <li class="tab col s3 <?php echo $isLoged; ?>"><a class="font-purista" href="#inscription<?php echo($mission['id']); ?>">Inscription</a></li>
                            </ul>
                        </div>

                        <!--Contenu du briefing-->
                        <div id="briefing<?php echo($mission['id']); ?>" class="col s12">
                            <div class="row hlp-top-t">
                                <div class="col s12 m6">
                                    <p>
                                        <b>Nom de code : </b><?php echo($mission['nom']); ?><br>
                                        <b>Date fixé : </b><?php echo($mission['date']); ?><br>
                                        <b>Nombre de joueur conseillé : </b><?php echo($mission['nbRqMinPlayer']); ?>-<?php echo($mission['nbRqMaxPlayer']); ?><br>
                                        <b>Nombre de joueur inscrit : </b><?php echo($mission['nbInsPlayer']); ?><br>
                                        <b>Faction jouer : </b><?php echo($mission['faction']); ?><br>
                                        <b>Localisation : </b><?php echo($mission['map']); ?><br>
                                    </p>
                                </div>

                                <div class="col s12 m6">
                                    <div class="hlp-padding-m">
                                        <img src="img/missile.jpg" class="responsive-img z-depth-3 center-block">
                                    </div>
                                </div>
                            </div>

                            <p>
                                <b>Situation :</b><br>
                                <?php echo($mission['briefing']); ?>
                            </p>

                            <p>
                                <b>Objectif :</b><br>
                                <?php echo($mission['objectif']); ?>
                            </p>
                        </div>

                        <!--Tableau des escouades de la mission-->
                        <div id="escouades<?php echo($mission['id']); ?>" class="col s12">
                            <?php $escouades = getEscouadesByIdMisssion($mission['id']); ?>
                            <div class="row no-row hlp-padding-m">
                                <div class="col s6 offset-s3">
                                    <h4 class="center-align font-purista">OMEGA</h4>
                                    <table class="centered striped">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Nom</th>
                                            <th data-field="name">Rôle</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach ($escouades as $escouade) {
                                                if ($escouade['escouade'] == "omega"){ ?>
                                                    <tr>
                                                        <td><?php echo $escouade['pseudo']; ?></td>
                                                        <td><?php echo $escouade['role']; ?></td>
                                                    </tr>
                                                <?php  }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col s5"><br>
                                    <h4 class="center-align font-purista">ALPHA</h4>
                                    <table class="centered striped">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Nom</th>
                                            <th data-field="name">Rôle</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($escouades as $escouade) {
                                            if ($escouade['escouade'] == "alpha"){ ?>
                                                <tr>
                                                    <td><?php echo $escouade['pseudo']; ?></td>
                                                    <td><?php echo $escouade['role']; ?></td>
                                                </tr>
                                            <?php  }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col s5 offset-s2"><br>
                                    <h4 class="center-align font-purista">BRAVO</h4>
                                    <table class="centered striped">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Nom</th>
                                            <th data-field="name">Rôle</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($escouades as $escouade) {
                                            if ($escouade['escouade'] == "bravo"){ ?>
                                                <tr>
                                                    <td><?php echo $escouade['pseudo']; ?></td>
                                                    <td><?php echo $escouade['role']; ?></td>
                                                </tr>
                                            <?php  }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col s5"><br>
                                    <h4 class="center-align font-purista">CHARLIE</h4>
                                    <table class="centered striped">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Nom</th>
                                            <th data-field="name">Rôle</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($escouades as $escouade) {
                                            if ($escouade['escouade'] == "charlie"){ ?>
                                                <tr>
                                                    <td><?php echo $escouade['pseudo']; ?></td>
                                                    <td><?php echo $escouade['role']; ?></td>
                                                </tr>
                                            <?php  }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col s5 offset-s2"><br>
                                    <h4 class="center-align font-purista">DELTA</h4>
                                    <table class="centered striped">
                                        <thead>
                                        <tr>
                                            <th data-field="id">Nom</th>
                                            <th data-field="name">Rôle</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($escouades as $escouade) {
                                            if ($escouade['escouade'] == "delta"){ ?>
                                                <tr>
                                                    <td><?php echo $escouade['pseudo']; ?></td>
                                                    <td><?php echo $escouade['role']; ?></td>
                                                </tr>
                                            <?php  }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--Formulaire d'inscription-->
                        <div id="inscription<?php echo($mission['id']); ?>" class="col s12">
                            <form method="post" class="container hlp-padding-m">
                                <?php $presence = getPresenceByIdMission($mission['id']) ?>
                                <h4 class="center-align font-purista">STATUS ACTUEL : <?php echo $presence ?></h4><br>
                                <div class="row">
                                    <div class="col s4">
                                        <div class="input-field">
                                            <select required name="role" class="role">
                                                <option value="" disabled selected>Selectionnez un rôle</option>
                                                <option value="Commandant" data-icon="images/sample-1.jpg" class="circle">Commandant</option>
                                                <option value="Chef d'escouade" data-icon="images/sample-1.jpg" class="circle">Chef d'escouade</option>
                                                <option value="Chef d'equipe" data-icon="images/sample-1.jpg" class="circle">Chef d'equipe</option>
                                                <option value="Médecin" data-icon="images/sample-1.jpg" class="circle">Médecin</option>
                                                <option value="Sapeur" data-icon="images/sample-1.jpg" class="circle">Sapeur</option>
                                                <option value="MG" data-icon="images/sample-1.jpg" class="circle">MG</option>
                                                <option value="Soldat régulier" data-icon="images/sample-1.jpg" class="circle">Soldat régulier</option>
                                            </select>
                                            <label>Rôle</label>
                                        </div>
                                    </div>

                                    <div class="col s4">
                                        <div class="input-field">
                                            <select required name="escouade" class="escouade">
                                                <option value="" disabled selected>Selectionnez une escouade</option>
                                                <option value="omega" data-icon="images/yuna.jpg" class="circle">Omega</option>
                                                <option value="alpha" data-icon="images/sample-1.jpg" class="circle">Alpha</option>
                                                <option value="bravo" data-icon="images/office.jpg" class="circle">Bravo</option>
                                                <option value="charlie" data-icon="images/yuna.jpg" class="circle">Charlie</option>
                                                <option value="delta" data-icon="images/yuna.jpg" class="circle">Delta</option>
                                            </select>
                                            <label>Escouade</label>
                                        </div>
                                    </div>

                                    <div class="col s4">
                                        <div class="input-field">
                                            <select required name="groupement" class="groupement">
                                                <option value="" disabled selected>Selectionnez un groupement</option>
                                                <option value="aucun">N/A</option>
                                                <option value="rouge" data-icon="img/rouge.png" class="circle">Rouge</option>
                                                <option value="bleu" data-icon="img/bleu.png" class="circle">Bleu</option>
                                                <option value="vert" data-icon="img/vert.png" class="circle">Vert</option>
                                                <option value="jaune" data-icon="img/jaune.png" class="circle">Jaune</option>
                                            </select>
                                            <label>Groupement</label>
                                        </div>
                                    </div>

                                    <div class="input-field col s6 offset-s3">
                                        <select required name="presence" class="presence">
                                            <option value="" disabled selected>Indiquez le statut de votre présence</option>
                                            <option value="PRESENT">Présent</option>
                                            <option value="PROBABLE">Probable</option>
                                            <option value="ABSENT">Absent</option>
                                        </select>
                                        <label>Présence</label>
                                    </div>

                                    <input name="idMission" type="text" value="<?php echo($mission['id']); ?>" hidden>
                                </div>

                                <!-- Trigger Modal d'avertissement -->

                                <div class="center-align">
                                    <a class="modal-trigger waves-effect waves-light btn font-purista" href="#modalInscription<?php echo($mission['id']); ?>">Mettre à jour votre statut</a>
                                </div>

                                <!-- Modal d'avertissement -->
                                <div id="modalInscription<?php echo($mission['id']); ?>" class="modal">
                                    <div class="modal-content">
                                        <h2 class="center-align font-purista">ATTENTION</h2>
                                        <img class="responsive-img center-block" src="img/warning.png">
                                        <p class="flow-text center-align">Le statut de votre présence ne peut plus être changer à partir du moment où
                                            vous avez confirmé votre présence</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn waves-effect waves-light font-purista red modal-action modal-close" style="margin-right: 6px; margin-left: 20px;">Annuler</button>
                                        <button class="btn waves-effect waves-light font-purista green" type="submit" name="INS" value="true">Valider</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </li>

            <?php } ?>

        </ul>
    </section>

    <footer class="page-footer" style="padding-top: -20px;">
        <div class="footer-copyright">
            <div class="container">
                © 2016 Copyright SinTeam Gaming
                <a class="grey-text text-lighten-4 right" href="#!">V 1.0</a>
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