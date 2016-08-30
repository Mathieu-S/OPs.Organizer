<?php

/**
 * @return PDO
 * Permet la connexion à la base de donnée
 */
function connectionDB() {
    $db = new PDO("mysql:host=localhost;dbname=opo;charset=utf8", "root", "root");
    return $db;
}

//////////////////////////////////////
//       Gère les utilisateurs      //
//////////////////////////////////////

/**
 * Ajoute un utilisateur à la base de données
 */
function addUser() {
    $db=connectionDB();
    //Vérifie si l'email n'est pas déjà utilisé
    $query = $db->prepare("SELECT * FROM `players` WHERE email = :email");
    $query->bindParam(':email', $_POST['email']);
    $query->execute();
    $row = $query->fetch();
    if ($row['email'] == $_POST['email']){
        return false;
    }
    //Vérifie si le speudo n'est pas déjà utilisé
    $query = $db->prepare("SELECT * FROM `players` WHERE pseudo = :pseudo");
    $query->bindParam(':pseudo', $_POST['pseudo']);
    $query->execute();
    $row = $query->fetch();
    if ($row['pseudo'] == $_POST['pseudo']) {
        return false;
    }
    //Ajoute l'utilisateur à la base de données.
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
    $query = $db->prepare("INSERT INTO `players`(`pseudo`, `mdp`, `email`) VALUES (:pseudo, :mdp, :email)");
    $query->bindParam(':pseudo', $_POST['pseudo']);
    $query->bindParam(':mdp', $mdp);
    $query->bindParam(':email', $_POST['email']);
    $query->execute();
    return true;
}

/**
 * Permet de se connecter et d'initialiser une session
 */
function connectUser() {
    $db = connectionDB();
    $query = $db->prepare("SELECT * FROM `players` WHERE `pseudo` = :pseudo");
    $query->bindParam(':pseudo', $_POST['pseudo']);
    $query->execute();
    $row = $query->fetch();
    if (password_verify($_POST['mdp'], $row['mdp'])) {
        $_SESSION['idPlayer'] = $row['id'];
        $_SESSION['pseudo'] = $row['pseudo'];
        $_SESSION['lvlHabilitation'] = $row['lvlHabilitation'];
        return true;
    } else {
        return false;
    }
}

//////////////////////////////////////
//         Gère les missions        //
//////////////////////////////////////

/**
 * Récupère les missions
 */
function getMissions() {
    $db=connectionDB();
    $query = $db->prepare("SELECT * FROM `missions` ORDER BY `id` DESC ");
    $query->execute();
    return $query->fetchAll();
}

/**
 * Ajoute une mission
 */
function addMission() {
    $db = connectionDB();
    $query = $db->prepare("INSERT INTO `missions`(`nom`, `date`, `nbRqMinPlayer`, `nbRqMaxPlayer`, `faction`, `map`, `briefing`, `objectif`) VALUES (:nomMission,:dateMission,:minPlayers,:maxPlayers,:faction,:localisation,:situation,:objetctif)");
    $query->bindParam(':nomMission', $_POST['nomMission']);
    $query->bindParam(':dateMission', $_POST['date']);
    $query->bindParam(':minPlayers', $_POST['minPlayers']);
    $query->bindParam(':maxPlayers', $_POST['maxPlayers']);
    $query->bindParam(':faction', $_POST['faction']);
    $query->bindParam(':localisation', $_POST['localisation']);
    $query->bindParam(':situation', $_POST['situation']);
    $query->bindParam(':objetctif', $_POST['objetctif']);
    $query->execute();
    return true;
}

//////////////////////////////////////
//    Gère les escouades/présence   //
//////////////////////////////////////

/**
 * Vérifie si déjà inscrit pour la mission
 */
function dejaInscrit($idMission) {
    $db = connectionDB();
    $query = $db->prepare("SELECT * FROM `escouades` WHERE `idMission` = :idMission AND `idPlayer` = :idPlayer");
    $query->bindParam(':idMission', $idMission);
    $query->bindParam(':idPlayer', $_SESSION['idPlayer']);
    $query->execute();
    $data = $query->fetchAll();
    if(key_exists('0', $data) ) {
        return $data['0']['enter'];
    }
    return false;
}

/**
 * Rafraichie le nombre de joueurs inscrit à une mission
 */
function refreshNbPlayerInscrit($idMission) {
    $db = connectionDB();
    $query = $db->prepare("SELECT COUNT('idPlayer') FROM `escouades` WHERE `idMission` = :idMission AND (`presence` = 'PRESENT' OR `presence` = 'PROBABLE')");
    $query->bindParam(':idMission', $idMission);
    $query->execute();
    $data = $query->fetch();
    $query = $db->prepare("UPDATE `missions` SET `nbInsPlayer`=:nbInsPlayer WHERE `id`=:idMission");
    $query->bindParam(':nbInsPlayer', $data['0']);
    $query->bindParam(':idMission', $idMission);
    $query->execute();
}

/**
 * Ajoute une mission
 */
function inscriptionMission() {
    $db = connectionDB();

    $inscrit = dejaInscrit($_POST['idMission']);

    if ($inscrit) {
        $query = $db->prepare("UPDATE `escouades` SET `escouade`=:escouade,`groupement`=:groupement,`role`=:role,`presence`=:presence WHERE `enter`=:enter");
        $query->bindParam(':enter', $inscrit);
        $query->bindParam(':escouade', $_POST['escouade']);
        $query->bindParam(':groupement', $_POST['groupement']);
        $query->bindParam(':role', $_POST['role']);
        $query->bindParam(':presence', $_POST['presence']);
        $query->execute();
        refreshNbPlayerInscrit($_POST['idMission']);
        header("Refresh:0");
        return true;
    } else {
        $query = $db->prepare("INSERT INTO `escouades`(`idMission`, `escouade`, `groupement`, `idPlayer`, `role`, `presence`) VALUES (:idMission,:escouade,:groupement,:idPlayer,:role,:presence)");
        $query->bindParam(':idMission', $_POST['idMission']);
        $query->bindParam(':escouade', $_POST['escouade']);
        $query->bindParam(':groupement', $_POST['groupement']);
        $query->bindParam(':idPlayer', $_SESSION['idPlayer']);
        $query->bindParam(':role', $_POST['role']);
        $query->bindParam(':presence', $_POST['presence']);
        $query->execute();
        refreshNbPlayerInscrit($_POST['idMission']);
        header("Refresh:0");
        return true;
    }
}

/**
 * Indique la présence ou non du joueur
 */
function getPresenceByIdMission($idMission) {
    $db=connectionDB();
    $query = $db->prepare("SELECT `presence` FROM `escouades` WHERE `idPlayer`=:idPlayer AND `idMission`=:idMission");
    $query->bindParam(':idPlayer', $_SESSION['idPlayer']);
    $query->bindParam(':idMission', $idMission);
    $query->execute();
    $result = ($query->fetch());
    if (empty($result)) {
        return "NON INSCRIT";
    }
    return $result['presence'];
}

/**
 * indique la présence ou non du joueur
 */
function getEscouadesByIdMisssion($idMission) {
    $db=connectionDB();
    $query = $db->prepare("SELECT * FROM `escouades` INNER JOIN `players` WHERE `escouades`.`idPlayer` = `players`.`id` AND `idMission` = :idMission AND (`presence` = 'PRESENT' OR `presence` = 'PROBABLE')");
    $query->bindParam(':idMission', $idMission);
    $query->execute();
    $data = ($query->fetchAll());
    return $data;
}