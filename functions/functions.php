<?php

/**
 * @return PDO
 * Permet la connexion à la base de donnée
 */
function connectionDB() {
    $db = new PDO("mysql:host=localhost;dbname=opo;charset=utf8", "root", "root");
    return $db;
}

/**
 * Récupère les missions
 */
function getMissions() {
    $db=connectionDB();
    $query = $db->prepare("SELECT * FROM `missions` ORDER BY `id` DESC ");
    $query->execute();
    return $query->fetchAll();
}
