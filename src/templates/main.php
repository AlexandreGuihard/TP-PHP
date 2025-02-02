<?php

use App\Controllers\Auth\Auth;
use App\Views\Flash;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ce811b00f8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./static/css/header.css">
    <link rel="stylesheet" href="./static/css/footer.css">
    <?php
    if (!empty($cssFiles)) {
        foreach ($cssFiles as $cssFile) {
            echo '<link rel="stylesheet" href="./static/css/' . $cssFile . '">';
        }
    }
    ?>
    <title><?php echo $title ?? null ?></title>
</head>
<body>

<header>
    <div class="logo">
        <img src="static/images/quiz.webp" alt="Logo">
        <h1>Quiz IUT'O</h1>
    </div>
    <nav class="nav-menu">
        <ul>
            <li><a href="./index.php"
                   class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && !isset($_GET['action']) || (isset($_GET['action']) && $_GET['action'] == 'home')) ? 'active' : ''; ?>">Accueil</a>
            </li>
            <?php
            if (!Auth::isUserLoggedIn()) {
                ?>
                <li><a href="index.php?action=register"
                       class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'register') ? 'active' : ''; ?>">Inscription</a>
                </li>
                <?php
            }else {
                ?>
                <li><a href="index.php?action=Historique"
                       class="<?php echo (isset($_GET['action']) && $_GET['action'] == 'historique') ? 'active' : ''; ?>">Historique</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
    <div class="actions">
        <?php
        if (Auth::isUserLoggedIn()) {
            

            echo '<a href="index.php?action=logout">Déconnexion</a>';
        } else {
            echo '<a href="index.php?action=login">Connexion</a>';
        }
        ?>
    </div>
</header>


<main>
    <?php Flash::flash();?>
    <?php echo $content ?? null ?>
</main>

<footer>
    <div class="col1">
        <H3>
            Quiz IUT'O
        </H3>
        <img src="static/images/quiz.webp" alt="logo">
    </div>

    <div class="col2">
        <H3>
            Contacts
        </H3>
        <p>02 38 49 44 62</p>
        <p>Rue d'issoudun, 45067 Orléans cedex 02</p>

    </div>
    <div class="col3">
        <H3>
            Membres de l'équipe
        </H3>
        <ul>
            <li>Mouad Zouadi</li>
            <li>Alexandre Guihard</li>
        </ul>

    </div>
    <div class="horizontal">
        <p><strong>&copy; 2024 - Tous droits réservés</strong></p>
    </div>

</footer>
</body>
</html>