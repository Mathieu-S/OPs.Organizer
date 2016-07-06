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
    $query = $db->prepare("INSERT INTO `players`(`pseudo`, `mdp`, `email`) VALUES (:pseudo, :mdp, :email)");
    $query->bindParam(':pseudo', $_POST['pseudo']);
    $query->bindParam(':mdp', $_POST['mdp']);
    $query->bindParam(':email', $_POST['email']);
    $query->execute();
}

/**
 * Permet de se connecter et d'initialiser une session
 */
function connectUser() {
    $db = connectionDB();
    $query = $db->prepare("SELECT * FROM `players` WHERE `pseudo` = :pseudo AND `mdp` = :mdp");
    $query->bindParam(':pseudo', $_POST['pseudo']);
    $query->bindParam(':mdp', $_POST['mdp']);
    $query->execute();
    $row = $query->fetch();
    if($query->rowCount()) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['pseudo'] = $row['pseudo'];
        $_SESSION['lvlAbilitation'] = $row["lvlAbilitation"];
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
