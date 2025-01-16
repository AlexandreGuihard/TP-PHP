<?php

use App\Controllers\RequeteBD;
use App\Controllers\Auth\Auth;


$id_user = Auth::getCurrentUser()['id'];
$scores = RequeteBD::getScore($id_user);




?>

<div class="page">
        <h1 class= "titre-historique">Historique de vos Scores</h1>

        <?php if (empty($scores)): ?>
            <p>Aucun score trouvé pour cet utilisateur.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom du Quiz</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scores as $score): ?>
                        <tr>
                            <td><?= htmlspecialchars($score['quiz_name']) ?></td> 
                            <td><?= $score['score'] ?> %</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>