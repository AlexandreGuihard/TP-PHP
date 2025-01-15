<?php

namespace App\Controllers\Auth;

use App;
use App\Controllers\Auth\Users\Instructor;
use App\Controllers\Auth\Users\User;
class Auth
{

    static function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    static function getCurrentUser() {
        if (self::isUserLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
            ];
        }
        return null;
    }

    static function getCurrentUserObj() {
        if (self::isUserLoggedIn()) {
            return self::getUserById($_SESSION['user_id']);
        }
        return null;
    }

    static function checkUserLoggedIn() {
        if(!self::isUserLoggedIn()){
            header('Location: /index.php');
        }
    }

    static function getUserByUsername($username) {
        $query = App::getApp()->getDB()->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(array(':username' => $username));
        $user = $query->fetch();
        if($user){
            return new User($user['id'], $user['username'], $user['password']);
        }
        return null;
    }


}
?>