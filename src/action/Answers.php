<?php

namespace action;
use App\Controllers\Questions;
use App\Controllers\Question;
use App\Controllers\RequeteBD;
use App\Controllers\Auth\Auth;
use App\Controllers\Auth\Users\User;


date_default_timezone_set('Europe/Paris');

class Answers
{
    public function answer_text( $q, ?string $v): int
    {
        if (is_null($v)) return 0;
        return $q->getAnswer() === $v ? $q->getScore() : 0;
    }

    public function answer_radio( $q, ?string $v): int
    {
        if (is_null($v)) return 0;
        return $q->getAnswer() === $v ? $q->getScore() : 0;
    }

    public function checkAnswers($quiz): void{
        echo "<h1>Voici les résultats du quiz</h1>";
        $score_total = 0;
        $score_correct = 0;
        $i = 1;
        $questions= $quiz->getQuestions();
        foreach ($questions as $q) {
            $score_total += $q->getScore(); // Ajout du score de la question
            $userAnswer = $_POST[$q->getName()] ?? null;

                // Vérification de la réponse entrée
                switch ($q->getQuestionType()) {
                    case "radio":
                        $score_correct += $this->answer_radio($q, $userAnswer);
                        echo "Réponse envoyée pour la question $i: " . ($userAnswer ? $q->getChoices()[$userAnswer] : 'Aucune réponse') . "<br>";
                        echo "Réponse à la question $i: " . $q->getChoices()[$q->getAnswer()] . "<br>";
                        break;
                    case "text":
                        $score_correct += $this->answer_text($q, $userAnswer);
                        echo "Réponse envoyée pour la question $i: " . ($userAnswer ? $userAnswer : 'Aucune réponse') . "<br>";
                        echo "Réponse à la question $i: " . $q->getAnswer() . "<br>";
                        break;
                }

            // Afficher la réponse correcte pour chaque question
            $i++;
        }

        // Affichage du score final
        echo "<p>Votre score: " . $score_correct . "/" . $score_total . "</p><br>";

        if(Auth::isUserLoggedIn()){
            $user_id = Auth::getCurrentUser()['id'];
            $pourcentage = ($score_correct / $score_total) * 100;
            RequeteBD::setScore($user_id,"quiz",$pourcentage);
            echo "<a href='index.php'>Retour à l'accueil</a>";

        }
        else {
            echo "Vous devez être connecté pour enregistrer votre score";
            echo "<a href='index.php?action=login'>Se connecter</a>";
        }

    }

}