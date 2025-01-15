<?php

namespace action;
use quiz\Questions;
class Answers
{
    public function answer_text(Question $q, ?string $v): int
    {
        if (is_null($v)) return 0;
        return $q->getAnswer() === $v ? $q->getScore() : 0;
    }

    public function answer_radio(Question $q, ?string $v): int
    {
        if (is_null($v)) return 0;
        return $q->getAnswer() === $v ? $q->getScore() : 0;
    }

//    public function checkAnswers(Questions $quiz): void{
//        echo "<h1>Voici les résultats du quiz</h1>";
//        $score_total = 0;
//        $score_correct = 0;
//        $i = 1;
//
//        foreach ($quiz->getQuestions() as $q) {
//            $score_total += $q->getScore();
//            $userAnswer = $_POST[$q->getName()] ?? null;
//            echo "Réponse envoyée pour la question $i: " . ($userAnswer ? $userAnswer : 'Aucune réponse') . "<br>";
//
//            if ($userAnswer !== null) {
//                switch ($q->getQuestionType()) {
//                    case "radio":
//                        $score_correct += $this->answer_radio($q, $userAnswer);
//                        break;
//                    case "text":
//                        $score_correct += $this->answer_text($q, $userAnswer);
//                        break;
//                }
//            }
//
//            // Afficher la réponse correcte pour chaque question
//            echo "Réponse à la question $i: " . $q->getAnswer() . "<br>";
//            $i++;
//        }
//        echo "Votre score: " . $score_correct . "/" . $score_total . "<br>";
//
//    }

public function checkAnswers(Questions $quiz): void{
    echo "<h1>Voici les résultats du quiz</h1>";
    $score_total = 0;  // Initialiser le score total
    $score_correct = 0;  // Initialiser le score correct
    $i = 1;

    $questions=$quiz->getQuestions();
    foreach ($questions as $q) {
        $score_total += $q->getScore();  // Ajouter le score de la question au score total
        $userAnswer = $_POST[$q->getName()] ?? null;
        echo "Réponse envoyée pour la question $i: " . ($userAnswer ? $userAnswer : 'Aucune réponse') . "<br>";

        if ($userAnswer !== null) {
            switch ($q->getQuestionType()) {
                case "radio":
                    $score_correct += $this->answer_radio($q, $userAnswer);  // Incrémenter le score correct pour la question
                    break;
                case "text":
                    $score_correct += $this->answer_text($q, $userAnswer);  // Incrémenter le score correct pour la question
                    break;
            }
        }

        // Afficher la réponse correcte pour chaque question
        echo "Réponse à la question $i: " . $q->getAnswer() . "<br>";
        $i++;
    }

    // Affichage du score final
    echo "Votre score: " . $score_correct . "/" . $score_total . "<br>";
}

}
