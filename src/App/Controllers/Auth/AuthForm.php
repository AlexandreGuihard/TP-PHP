<?php

namespace App\Controllers\Auth;

use App\Controllers\Auth\Users\User;
use App\Controllers\Auth\Auth;

class AuthForm {

    static function checkLoginForm($username, $password) {
        $user = Auth::getUserByUsername($username);

        if($user){
            //verify password
            if(password_verify($password, $user->password)){
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                header('Location: /');
            }else{
                $error = 'Mot de passe incorrect';
            }
        }else{
            $error = "Nom d'utilisateur incorrect";
        }

        return $error;
    }

    static function checkRegisterForm($username, $password) {
        $user = Auth::getUserByUsername($username);

        if(!$user){
            $userObj = new User(null, $username, $password);
            $userObj->register();

            header('Location: /index.php?action=login');
        }else{
            $error = "Un utilisateur avec ce username existe déjà";
        }

        return $error;
    }
}

?>