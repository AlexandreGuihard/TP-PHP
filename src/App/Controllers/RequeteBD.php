<?php

namespace App\Controllers;

use App;
use PDO;



use PDOException;


if (!class_exists(\App::class)) {

    define('ROOT', $_SERVER['DOCUMENT_ROOT']);

    require ROOT . '/App/App.php';

    App::getApp();
}

class RequeteBD
{



    static function getScore($id_client)
    {
        $db = App::getApp()->getDB();
        $query = $db->prepare('SELECT score,quiz_name FROM scores WHERE user_id = :id_client');
        $query->execute(['id_client' => $id_client]);
        $score = $query->fetchAll(PDO::FETCH_ASSOC);
        return $score;
        
    }

    static function setScore($id_client,$quiz_name, $score)
    {
        $score = intval($score);
    
        $db = App::getApp()->getDB();
        $query = $db->prepare('INSERT INTO scores (user_id, quiz_name, score) VALUES (:id_client, :quiz_name, :score)');
        $query->execute([
            'id_client' => $id_client, 
            'quiz_name' => $quiz_name, 
            'score' => $score,
        ]);
    }
    

    static function lastId() {
        $db = App::getApp()->getDB();
        
        $query = $db->prepare('SELECT IFNULL(MAX(id), 0) AS last_id FROM users');
        $query->execute();
        $lastId = $query->fetch(PDO::FETCH_ASSOC);
    

        $newId = (int) $lastId['last_id'] + 1;
        
        return $newId;  
    }

    static function deleteUser(){
        $db = App::getApp()->getDB();
        $query = $db->prepare('DELETE FROM users ');
        $query->execute();

    }
}