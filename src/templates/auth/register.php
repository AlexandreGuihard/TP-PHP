<?php

use App\Controllers\Auth\AuthForm;


//if is post request
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //get post data
    $username = $_POST['username'];
    $password = $_POST['password'];

    $error = AuthForm::checkRegisterForm($username, $password);
}

?>
<div class="page">
<div class="login">
    <div class="login-container">
        <h2>S'inscrire maintenant</h2>
        
        <form action="#" method="post">
            <div class="input-row">
                <div class="input-container">
                    <input type="text" placeholder="username" name="username" required>
                </div>
            </div>
        
            <div class="input-container">
                <input type="password" placeholder="Mot de passe" name="password" required>
            </div>

            <?php
            if (isset($error)) {
                echo '<p class="error-message">*' . $error . '</p>';
            }
            ?>
            <button type="submit">S'inscrire</button>
        </form>

        <a href="./index.php?action=login" class="register-link">Déjà un compte ? Connectez-vous</a>
    </div>
</div>
</div>