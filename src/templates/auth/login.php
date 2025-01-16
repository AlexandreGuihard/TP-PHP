<?php

use App\Controllers\Auth\AuthForm;

//if is post request
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //get post data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = AuthForm::checkLoginForm($username, $password);
    

}
?>

<div class="page">
<div class="login">
    <div class="login-container">
        <h2>Se connecter</h2>
        <form action="#" method="post">
            <div class="input-container">
                <input name="username" type="text" placeholder="nom utilisateur" required>
            </div>
            <div class="input-container">
                <input name="password" type="password" placeholder="Mot de passe" required>
            </div>
            <?php
            if (isset($error)) {
                echo '<p class="error-message">*' . $error . '</p>';
            }
            ?>
            <button type="submit">Se connecter</button>
        </form>
        
        <a href="./index.php?action=register" class="register-link">Pas encore de compte ? Inscrivez-vous</a>
    </div>
</div>
</div>