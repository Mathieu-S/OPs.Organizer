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
        $_SESSION['id'] = $row['id'];
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
