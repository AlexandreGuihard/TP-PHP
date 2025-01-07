<h1>Remplissez le feurmulaire</h1>
<form action="" method="post">
    <?php
    foreach($questions as $question):?>
        <p> <?php echo $question->render()?></p>
    <?php endforeach; ?>
    <input type="submit" value="Valider">
</form>